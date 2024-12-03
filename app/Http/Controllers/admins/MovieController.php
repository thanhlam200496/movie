<?php

namespace App\Http\Controllers\admins;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Episode;
use App\Models\Movie;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        return view('admin_movie.movies.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_year' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'age_rating' => 'nullable|integer|min:0|max:18',
            'duration' => 'required|integer|min:1', // Thời lượng phim phải lớn hơn 0 phút
            'video_url' => 'nullable',

            'director' => 'nullable|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:10', // Xếp hạng từ 0 đến 10
            'type_film' => 'required|in:TV Show,Movie',
            'poster_url' => 'nullable', // URL của poster
            'trailer_url' => 'nullable', // URL của trailer
            'views' => 'nullable|integer|min:0',
            'status' => 'required|in:Hidden,Public,Not Released'
        ], [
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'release_year.required' => 'Năm phát hành là bắt buộc.',
            'release_year.digits' => 'Năm phát hành phải là số có 4 chữ số.',
            'release_year.min' => 'Năm phát hành phải từ năm 1900 trở đi.',
            'release_year.max' => 'Năm phát hành không được lớn hơn năm hiện tại.',
            'age_rating.integer' => 'Độ tuổi phải là một số nguyên.',
            'age_rating.min' => 'Độ tuổi tối thiểu là 0.',
            'age_rating.max' => 'Độ tuổi tối đa là 18.',
            'duration.required' => 'Thời lượng là bắt buộc.',
            'duration.integer' => 'Thời lượng phải là một số nguyên.',
            'duration.min' => 'Thời lượng phải lớn hơn 0 phút.',
            'video_url.url' => 'URL video phải là một đường dẫn hợp lệ.',
            'rating.numeric' => 'Xếp hạng phải là một số.',
            'rating.min' => 'Xếp hạng tối thiểu là 0.',
            'rating.max' => 'Xếp hạng tối đa là 10.',
            'type_film.required' => 'Loại phim là bắt buộc.',
            'type_film.in' => 'Loại phim không hợp lệ.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);
        $data = $request->all('link_poster_internet', 'slug','link_video_internet', 'title', 'poster_url', 'type_film', 'duration', 'age_rating', 'release_year', 'description', 'age_rating', 'status', 'video_url');

        if ($request->hasFile('poster_url')) {
            $poster_url = $request->file('poster_url')->getClientOriginalName() . '_' . Carbon::now()->timestamp . '.' . $request->poster_url->getClientOriginalExtension();
            $request->file('poster_url')->storeAs('public/images', $poster_url);
            $data['poster_url'] = $poster_url;
        }

        if ($request->countries != null) {
            $countries = implode(', ', $request->countries);
            $data['countries'] = $countries;
        }


        if ($request->hasFile('video_url')) {
            $video_url = $request->file('video_url')->getClientOriginalName() . '_' . Carbon::now()->timestamp . '.' . $request->video_url->getClientOriginalExtension();
            $request->file('video_url')->storeAs('public/videos', $video_url);
            // $data['video_url']=$video_url;
        }
        $movie = Movie::create($data);
        $movie_category_id = Movie::find($movie->id);
        $movie_category_id->categories()->attach($request->categories_id);
        if ($request->type_film == 'Movie') {
            $dataEpisode = [
                'movie_id' => $movie->id,
                'title' => 'Special Episode',
                'episode_number' => 1
            ];
            if (isset($request->link_video_internet)) {
                $dataEpisode['link_video_internet'] = $request->link_video_internet;
            }
            if ($request->hasFile('video_url')) {
                $dataEpisode['video_url'] = $video_url;
            }
            Episode::create($dataEpisode);
        }
        // dd($data);

        return redirect()->route('admin.movie.index')->with('success', 'Thêm mới phim thành công');
    }
    public function index(Request $request)
    {
        $query = Movie::query();
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        if ($request->has('filter') && $request->filter == "date-created") {
            $movies = $query->orderBy('created_at', 'DESC');
        }
        if ($request->has('filter') && $request->filter == "rating") {
            $movies = $query->orderBy('rating', 'DESC');
        }
        if ($request->has('filter') && $request->filter == "views") {
            $movies = $query->orderBy('views', 'DESC');
        }
        $movies = $query->paginate(5);
        return view('admin_movie.movies.index', compact('movies'));
    }

    public function paginate(Request $request)
    {
        // Lấy danh sách phim phân trang
        $movies = Movie::paginate(10); // Giả sử bạn đang phân trang dữ liệu phim
        return response()->json($movies); // Đảm bảo trả về JSON
    }
    public function show(Movie $movie)
    {
        
        $categories = $movie->categories;
        $allCategories = Category::orderBy('name', 'ASC')->get();
        $countries = explode(', ', $movie->countries);
        return view('admin_movie.movies.show', compact('movie', 'categories', 'countries', 'allCategories'));
    }
    public function update(Movie $movie, Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'release_year' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'age_rating' => 'nullable|integer|min:0|max:18',
            'duration' => 'required|integer|min:1', // Thời lượng phim phải lớn hơn 0 phút
            'video_url' => 'nullable',

            'director' => 'nullable|string|max:255',
            'rating' => 'nullable|numeric|min:0|max:10', // Xếp hạng từ 0 đến 10
            'type_film' => 'required|in:TV Show,Movie',
            'poster_url' => 'nullable', // URL của poster
            'trailer_url' => 'nullable', // URL của trailer
            'views' => 'nullable|integer|min:0',
            'status' => 'required|in:Hidden,Public,Not Released'
        ], [
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'release_year.required' => 'Năm phát hành là bắt buộc.',
            'release_year.digits' => 'Năm phát hành phải là số có 4 chữ số.',
            'release_year.min' => 'Năm phát hành phải từ năm 1900 trở đi.',
            'release_year.max' => 'Năm phát hành không được lớn hơn năm hiện tại.',
            'age_rating.integer' => 'Độ tuổi phải là một số nguyên.',
            'age_rating.min' => 'Độ tuổi tối thiểu là 0.',
            'age_rating.max' => 'Độ tuổi tối đa là 18.',
            'duration.required' => 'Thời lượng là bắt buộc.',
            'duration.integer' => 'Thời lượng phải là một số nguyên.',
            'duration.min' => 'Thời lượng phải lớn hơn 0 phút.',
            'video_url.url' => 'URL video phải là một đường dẫn hợp lệ.',
            'rating.numeric' => 'Xếp hạng phải là một số.',
            'rating.min' => 'Xếp hạng tối thiểu là 0.',
            'rating.max' => 'Xếp hạng tối đa là 10.',
            'type_film.required' => 'Loại phim là bắt buộc.',
            'type_film.in' => 'Loại phim không hợp lệ.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);
        $data = $request->all('link_poster_internet', 'slug','link_video_internet', 'title', 'type_film', 'duration', 'age_rating', 'release_year', 'description', 'age_rating', 'status');

        if ($request->hasFile('poster_url_new')) {
            $poster_url = $request->file('poster_url_new')->getClientOriginalName() . '_' . Carbon::now()->timestamp . '.' . $request->poster_url_new->getClientOriginalExtension();
            $request->file('poster_url_new')->storeAs('public/images', $poster_url);
            $data['poster_url'] = $poster_url;
        }
        if ($request->hasFile('video_url_new')) {
            $video_url = $request->file('video_url_new')->getClientOriginalName() . '_' . Carbon::now()->timestamp . '.' . $request->video_url_new->getClientOriginalExtension();
            $request->file('video_url_new')->storeAs('public/videos', $video_url);
            // $data['video_url'] = $video_url;
        }
        if ($request->countries != null) {
            $countries = implode(', ', $request->countries);
            $data['countries'] = $countries;
        }

        // dd($data);
        $movie->update($data);
        $movie_category_id = Movie::find($movie->id);
        $movie_category_id->categories()->sync($request->categories_id);
        if ($request->type_film == 'Movie') {
            $dataEpisode = [
                
            ];  
            if (isset($request->link_video_internet)) {
                $dataEpisode['link_video_internet'] = $request->link_video_internet;
            }
            if ($request->hasFile('video_url_new')) {
                $dataEpisode['video_url'] = $video_url;
            }
            $episode=Episode::where('movie_id',$movie->id);
            $episode->update($dataEpisode);
        }
        return redirect()->route('admin.movie.index')->with('success', 'Cập nhật phim ' . $movie->title . ' thành công');
    }
    public function destroy(Movie $movie)
    {
        $message = 'Phim ' . $movie->title . ' được xóa thành công';
        $movie->delete();
        return redirect()->route('admin.movie.index')->with('success', $message);
    }
    public function update_status($id)
    {

        $movie = Movie::find($id);
        if ($movie->status == "Not Released") {
            $movie->status = "Public";
        } else
        if ($movie->status == "Hidden") {
            $movie->status = "Public";
        } else
        if ($movie->status == "Public") {
            $movie->status = "Hidden";
        }
        $movie->save();
        return redirect()->route('admin.movie.index')->with('success', 'Cập nhật phim ' . $movie->title . ' thành công');
    }
}
