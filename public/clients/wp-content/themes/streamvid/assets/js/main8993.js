var jwsThemeModule;
(function ($) {
	"use strict";
	jwsThemeModule = (function () {
		return {
			jws_script: jws_script,
			init: function () {
				this.login_form();
				this.header_sticky();
				this.search_product();
				this.menu_mobile();
				this.scrollTop();
				this.menu_list();
				this.mobile_default();
				this.menu_offset();
				this.video_popup();
				this.init_jws_notices();
				this.contact_form_loading();
				this.events_click_hover();
				this.select2_global()
				this.dropdown_ui();
				this.movies_offset();
				this.format_date_field();
				this.hover_videos();
				this.video_detail_popup();
			},

			isYoutubeVideo: function (url) {
				return url.includes("youtube.com") || url.includes("youtu.be");
			},


			isVimeoVideo: function (url) {
				return url.includes("vimeo.com");
			},

			getYouTubeID: function (url) {
				var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??(v=)?([^#\&\?]*).*/;
				var match = url.match(regExp);
				if (match && match[8].length == 11) {
					return match[8];
				} else {
					return null;
				}
			},

			video_detail_popup: function () {

				$(document).on('click', ".close-button , .close-overlay", function (e) {
					$('#jws-quickview-single').removeClass('open').remove();
				});
				$(document).on('click', ".jws-popup-detail", function (e) {
					e.preventDefault();
					var button = $(this);
					var id = button.data('post-id');
					var data = {
						id: id,
						action: "jws_videos_quickview",
					};

					button.addClass('loading');
					if (!button.find('.loader').length) {
						button.append('<div class="loader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/></svg></div>');
					}
					if ($('#jws-quickview-single').length <= 0) {
						$('body').append('<div id="jws-quickview-single"></div>');
					}

					$.ajax({
						url: jws_script.ajax_url,
						data: data,
						type: 'POST',
						dataType: 'json',
					}).success(function (response) {

						$('#jws-quickview-single').html(response.data.content);
						$('#jws-quickview-single').addClass('open');
						var $this = $("#jws-videos-detail");
						var player = $this.find('.video-player > .post-media');
						var $trailer = player.data('trailer');

						$this.find('.video-player').append('<div class="change-speaker muted"><i class="jws-icon-speaker-x"></i></div>');


						jwsThemeModule.video_init_trailer($trailer, player, $this);
						jwsThemeModule.owl_caousel_init($this.find('.owl-carousel'));

					}).complete(function () {
						button.removeClass('loading');

					}).error(function (ex) {
						console.log(ex);
					});
				});

			},

			hover_videos: function () {
				var hideTimer;


				var checkex = false;
				var $this_hover = false;

				if ($(window).width() <= 400) return false;

				$(document).on('mouseover', ".jws-post-item .post-inner", function () {

					if (checkex || !$(this).hasClass('hover-video') || $('.profile-main').hasClass('editor')) {
						return false;
					}

					var button = $(this);


					hideTimer = setTimeout(function () {
						var content = button.clone();


						$(".external-div .external-inner").html(content).show();
						var $this = $(".external-div .external-inner");
						var player = $this.find('.post-media');
						var $trailer = player.data('trailer');

						if ($trailer != '') {
							$this.append('<div class="change-speaker muted"><i class="jws-icon-speaker-x"></i></div>');
						}



						jwsThemeModule.video_init_trailer($trailer, player, $this);



						// Get position of the hovered item
						var position = button.offset();
						var width = button.width();
						var height = button.height();

						var right_of = $(window).width() - (position.left + button.outerWidth(true));
						var origin = 'center center';
						var left = position.left;


						if (right_of <= button.outerWidth(true)) {
							origin = 'center right';
							left = left - 70;
						}

						if (right_of <= 0) {
							origin = 'center right';
							left = $(window).width() - button.outerWidth(true) - 70;
						}

						if (position.left <= button.outerWidth(true)) {
							origin = 'center left';
							left = left + 70;
						}


						left = left - 70;

						if (left < 0) {
							left = 0;
						}

						// Set transform-origin dynamically
						$(".external-div .external-inner").css({
							'transform-origin': origin,
							'transform-scale': '1.1',
							'top': position.top - 40 + 'px',
							'left': left + 'px',
							'width': width + 140,

						}).addClass('active');

						$this_hover = button;
						$this_hover.addClass('hovered');
						checkex = true;
					}, 600);
				});

				$("body").mousedown(function () {
					if (hideTimer) {
						clearTimeout(hideTimer);
						hideTimer = null;
					}
				});
				$("body").mouseover(function (e) {
					if (hideTimer) {
						clearTimeout(hideTimer);
						hideTimer = null;
					}
					if (!$(e.target).parents('.external-div').length && checkex) {
						$(".external-div .external-inner").addClass('removeing');
						setTimeout(function () {

							$(".external-div .external-inner").hide().empty().removeClass('active').removeClass('removeing');

						}, 500);


						checkex = false;
						$this_hover.removeClass('hovered');
						$this_hover = false;

					}

				});

			},

			video_init_trailer: function ($trailer, player, $this) {
				var player_api;
				if ($trailer) {
					if (jwsThemeModule.isYoutubeVideo($trailer)) {

						var $trailer_url = jwsThemeModule.getYouTubeID($trailer);
						let $plex = '';

						if ($this.parents('#jws-quickview-single').length) {
							$plex = 'p';
						}

						player.html('<div id="hv_' + $plex + $trailer_url + '" ></div>');

						if (typeof YT != 'undefined') {
							var player = new YT.Player('hv_' + $plex + $trailer_url, {
								videoId: $trailer_url,
								playerVars: {
									loop: 1,
									playlist: $trailer_url,
									controls: 0,
									modestbranding: 1,
									rel: 0,
									fs: 0,
									iv_load_policy: 3,
								},
								width: '100%',
								height: '100%',
								events: {
									'onReady': onPlayerReady,
								}
							});
						}

						function onPlayerReady(event) {

							event.target.playVideo();

							if ($this.find(".change-speaker").hasClass('muted')) {

								event.target.mute();
							}

							$this.find(".change-speaker").on('click', function () {

								if (event.target.isMuted()) {
									$(this).html('<i class="jws-icon-speaker-high"></i>');

									event.target.unMute();
								} else {
									event.target.mute();
									$(this).html('<i class="jws-icon-speaker-x"></i>');

								}
							});
						}

					} else {

						player.html('<video id="video_hover"  autoplay muted playsinline><source src="' + $trailer + '" type="video/mp4"></video>');
						$this.find(".change-speaker").on('click', function () {
							var video = document.getElementById('video_hover');

							$(this).toggleClass('muted');

							if (video == null) return false;

							if ($(this).hasClass('muted')) {
								$(this).html('<i class="jws-icon-speaker-x"></i>');
							} else {
								$(this).html('<i class="jws-icon-speaker-high"></i>');
							}


							video.muted = !video.muted;

						});





					}
				}



			},


			owl_caousel_init: function ($container) {

				if ($container.length <= 0) {
					return false;
				}
				$container.data('options', $container.data('owl-option'));
				var options = $container.data('options');
				var autoplay = false;

				if (typeof options != 'undefined') { autoplay = (options.autoplay) ? true : false; }

				options = $.extend({}, options, { "autoplayHoverPause": autoplay });
				$container.owlCarousel(options);
				$container.removeAttr("data-owl-option");

			},

			format_date_field: function () {

				$('#jws_date_of_birth').datepicker({
					dateFormat: "dd-mm-yy",
					showOtherMonths: true,
					changeMonth: true,
					changeYear: true,
					selectOtherMonths: true,
					required: true,
					showOn: "focus",
					yearRange: "c-100:c+100",
				});

			},

			show_notification_error: function ($content, $role) {

				return 'There is a problem with the network connection, please try again.';

			},

			show_notification: function ($content, $role) {


				function createCustomToast() {
					var toastContent = document.createElement("div");
					toastContent.innerHTML = '<div class="mess-inner fs-small">' + $content + '</div>';
					return toastContent;
				}

				if ($content) {

					var bg = '#438f3e';

					if ($role == 'error') {
						bg = '#bf9537';
					}

					Toastify({
						node: createCustomToast(),
						duration: 4000,
						close: true,
						gravity: 'bottom',
						position: 'center',
						stopOnFocus: true,
						style: {
							background: bg,
						},
					}).showToast();
				}


			},

			movies_offset: function () {



				$('.jws-movies_advanced-element').each(function () {

					var $container = $(this).find('.movies_advanced_content');


					if ($container.hasClass('layout3')) {

						$(window).on('resize', function () {
							check_offsect_hover($container)
						});
						check_offsect_hover($container);

					}


					if ($container.hasClass('layout4')) {

						$(window).on('resize', function () {
							check_offsect_hover2($container)
						});
						check_offsect_hover2($container);

					}


				});



				function check_offsect_hover2($container) {


					let viewportWidth = $(document).width();
					let delay = 500;
					var timeoutId;

					let hover = $container.find('.post-media');

					$container.on('mouseenter', '.post-media', function () {

						clearTimeout(timeoutId);
						let btn = $(this).parents('.owl-item');
						let width_hover = btn.find('.content-hover').width();
						let offsect_right = viewportWidth - btn.offset().left - width_hover;

						timeoutId = setTimeout(function () {

							if (offsect_right < hover.width()) {
								btn.prevAll().addClass('move-left');
								btn.addClass('offset-c');
							} else {
								btn.nextAll().addClass('move-right');
								btn.removeClass('offset-c');
							}

						}, delay);

						btn.find('.content-hover').css('background-image', 'url(' + btn.find('.content-hover').attr('data-url') + ')');
					});

					$container.on('mouseleave', '.post-media', function () {

						clearTimeout(timeoutId);

						$container.find('.owl-item').removeClass('move-left').removeClass('move-right');


					});



				}

				function check_offsect_hover($container) {
					let viewportWidth = $(document).width();
					$container.on('mouseenter', function () {

						$container.find('.jws-post-item').each(function () {
							let item = $(this);
							let width_hover = item.find('.content-hover').width();
							let offsect_right = viewportWidth - item.offset().left - item.width() - width_hover;
							if (offsect_right < 0) {
								item.addClass('offset-c');
							} else {
								item.removeClass('offset-c');
							}
						});
					});
					$container.find('.offset-c').on('mouseenter', function () {

						$(this).prevAll().addClass('move-left');

					});
					$container.find('.offset-c').on('mouseleave', function () {

						$(this).prevAll().removeClass('move-left');

					});



				}



			},




			/**
			*-------------------------------------------------------------------------------------------------------------------------------------------
			* Load more button for blog
			*-------------------------------------------------------------------------------------------------------------------------------------------
			*/

			loadmore_btn: function ($scope) {
				var $element = $scope.find('[data-ajaxify=true]');
				var options = $element.data('ajaxify-options');
				if ($element.length < 1) return false;
				var wap = options.wrapper;
				$(document.body).on('click', '.jws-load-more', function (e) {
					e.preventDefault();
					var $this = $(this);
					$(this).append('<div class="loader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/></svg></div>');
					$(this).addClass('loading');
					var url = $this.attr('href');

					if ('?' == url.slice(-1)) {
						url = url.slice(0, -1);
					}

					url = url.replace(/%2C/g, ',');


					$.get(url, function (res) {

						var $newItemsWrapper = $(res).find(options.wrapper);
						var $newItems = $newItemsWrapper.find(options.items);
						$this.removeClass('loading');
						if (!$newItems.length) {
							$this.addClass('all-items-loaded');
						}
						$(wap).append($newItems);

						$this.find('.loader').remove();


						$this.parents('.jws_pagination').html($(res).find(wap).next('.jws_pagination').html());

					}, 'html');
				});

			},


			dropdown_ui: function () {

				$(document).on('click', function (event) {
					$('.jws-dropdown-ui').removeClass('open');
				});

				$(document).on('click', '.jws-dropdown-ui .dr-button', function (event) {
					if ($(this).parents('.jws-dropdown-ui').find('.dropdown-menu').length >= 1) {
						event.stopPropagation();
						event.preventDefault();;
					}
					$('.jws-dropdown-ui').removeClass('open');
					$(this).parents('.jws-dropdown-ui').toggleClass('open');
				});

			},

			select2_global: function () {

				$('select:not([aria-labelledby])').select2({
					dropdownAutoWidth: true,
					minimumResultsForSearch: 10
				});

			},



			fixHeight: function (elem) {
				var maxHeight = 0;
				elem.css('height', 'auto');
				elem.each(function () {
					if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
				});
				elem.height(maxHeight);
			},


			contact_form_loading: function () {
				$(document).on('click', '.wpcf7-submit', function () {
					if (!$(this).parents('.wpcf7-form').find('.loader').length) {
						$(this).parents('.wpcf7-form').append('<div class="loader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/></svg></div>');
					}
				});
			},
			jws_carousel: function ($scope, $) {
				$scope.find('.jws-carousel').eq(0).each(function () {
					var $this = $(this);


					var option_attr = $this.find('.carousel').data('slick');

					if (typeof option_attr === 'undefined') return false;

					option_attr.navigation = {
						nextEl: $this.find('.jws-button-next'),
						prevEl: $this.find('.jws-button-prev'),
					}

					option_attr.pagination = {
						el: $this.find('.custom_dots'),
						clickable: true,
					}


					if (typeof Swiper !== 'undefined') {
						if (option_attr.direction == 'vertical') {
							$this.find('.carousel').css('height', $this.find('.swiper-slide').height());
						}
						new Swiper($this.find('.carousel'), option_attr);
					}
				});


			},


			init_jws_notices: function () {
				$(document).on('click', '.show_filter_shop', function () {
					$('#jws-shop-topbar').slideToggle();
					$(this).toggleClass('active');
					$('.jws-filter-modal').fadeIn().addClass('open');
					$('.sidebar-sideout').addClass('opened').toggleClass('open');
				});
				$(document).on('click', '.modal-close , .modal-overlay', function () {
					$('.jws-filter-modal').fadeOut().removeClass('open');
					$('.show_filter_shop').removeClass('active');
				});
				$('body').on('click', '.jws-icon-cross', function (e) {
					e.preventDefault();
					var _this = $(this).parents('[role="alert"]');
					_this.remove();

				});

			},


			menu_list: function () {
				$(document).on("click", 'body[data-elementor-device-mode="mobile"] .jws-menu-list.toggle-mobile .menu-list-title', function () {
					$(this).next('ul').slideToggle();
				});
			},


			/* Car form for autocomplete input fields*/
			search_product: function () {

				let $check_submit = false;


				$('.jws-search-form form').each(function () {

					var form = $(this);
					var s = form.find('.s');
					let timeout = null;
					$(document).on("change", '.choose-post', function () {
						form.find('[name="post_type"]').val($(this).val());
						if (s.val() != '') {
							s.trigger('keyup');
						}
					});

					if (form.hasClass('search-inline')) {
						s.focus(function () {
							form.addClass('focused');
						});
						$(document).on("click", function (event) {
							var target = $(event.target);
							if (!target.closest(".jws-search-form").length) {
								form.removeClass("focused");
							}
						});

					}

					form.on('submit', function (e) {

						if (!$check_submit) {
							e.preventDefault();
						}


					});
					s.on('keyup', function () {

						clearTimeout(timeout);

						$check_submit = false;
						var formData = new FormData();

						formData.append('s', $(this).val());
						formData.append('post_type', $('[name="post_type"]').val());

						if (form.hasClass('search-inline')) {
							formData.append('type_query', 'all');
						}


						formData.append('action', 'jws_ajax_search');

						if (!form.find('.form-loader .loader').length) {
							form.find('.form-loader').append('<div class="loader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/></svg></div>');
						}

						form.addClass('search-loading');
						timeout = setTimeout(function () {

							$.ajax({
								url: jws_script.ajax_url,
								data: formData,
								method: 'POST',
								contentType: false,
								processData: false,
								success: function (response) {
									form.removeClass('search-loading');
									$('.jws-search-results').html(response.data.results);
									if (response.data.type_result.length > 0) {
										$check_submit = true;
										form.find('[name="post_type"]').val(response.data.type_result[0]);

									}


								},
								error: function () {
									$('.jws-search-results').html('<p class="not-found fs-small">Data error re-entering keywords</p>');
								},
								complete: function () { },
							});

						}, 1000);



					});


				});


			},

			header_sticky: function () {
				if ($('.jws_box_bulder').length) { return false; }
				if ($('.cafe-row-sticky')[0]) {

					$('.cafe-row-sticky').each(function () {
						var $this = $(this);
						var $sidebar = $('.jws_sticky_move');
						var $parent = $(this).parent();
						var current_width = 0;
						var old_height = $this.outerHeight();
						$(window).resize(function () {
							if (current_width != $(window).width()) {
								current_width = $(window).outerWidth();
								if (current_width > 1024.98 && $this.hasClass('desktop-sticky')) {
									$parent.height(old_height);
								} else if (current_width < 1024.98 && current_width > 768.98 && $this.hasClass('tablet-sticky')) {
									$parent.height($this.outerHeight());
								} else if (current_width < 768.98 && $this.hasClass('mobile-sticky')) {
									$parent.height($this.outerHeight());
								} else {
									$this.removeClass('is-sticky');
									$this.find('.elementor-widget-clever-site-logo').removeClass('header-is-sticky');
									$parent.height('auto');
								}
							}
						}).resize();
						var HeaderTop = $parent.offset().top - $('body').offset().top;
						var old_top_position = 0;


						$(window).on('scroll', function () {

							var top = $(window).scrollTop();
							if ($this.hasClass('cafe-scroll-up-sticky')) {
								top = top - $parent.outerHeight();
								if (old_top_position > top && top > $parent.outerHeight() * 3) {
									$this.not('.active-sticky').addClass('active-sticky');
									$this.removeClass('no-active-sticky');
									$sidebar.removeClass('no-active-sticky');
								} else {
									$this.removeClass('active-sticky');
									if ($this.hasClass('is-sticky')) {
										$this.addClass('no-active-sticky');
										$sidebar.addClass('no-active-sticky');
									}
								}
								old_top_position = top;
							}
							if (current_width > 1024.98 && $this.hasClass('desktop-sticky')) {
								if (HeaderTop < top) {
									$this.not('.is-sticky').addClass('is-sticky');
									$this.find('.elementor-widget-clever-site-logo:not(.header-is-sticky)').addClass('header-is-sticky');
									$('.cafe-wrap-menu .toggle .arrow.on-scroll').parents('.cafe-wrap-menu').removeClass('toggle-active');
									$('.cafe-wrap-menu .toggle .arrow.on-scroll').parents('.cafe-wrap-menu').find('.wrap-menu-inner').slideUp();
								} else {
									$this.removeClass('is-sticky');
									$this.removeClass('no-active-sticky');
									$sidebar.removeClass('no-active-sticky');
									$this.find('.elementor-widget-clever-site-logo').removeClass('header-is-sticky');
									$('.cafe-wrap-menu .toggle .arrow.on-scroll').parents('.cafe-wrap-menu').addClass('toggle-active');
									$('.cafe-wrap-menu .toggle .arrow.on-scroll').parents('.cafe-wrap-menu').find('.wrap-menu-inner').slideDown();
								}
							} else if (current_width < 1024.98 && current_width > 768.98 && $this.hasClass('tablet-sticky')) {
								if (HeaderTop < top) {
									$this.not('.is-sticky').addClass('is-sticky');
									$this.find('.elementor-widget-clever-site-logo').addClass('header-is-sticky');
									$('.cafe-wrap-menu .toggle .arrow.on-scroll').parents('.cafe-wrap-menu').removeClass('toggle-active');
									$('.cafe-wrap-menu .toggle .arrow.on-scroll').parents('.cafe-wrap-menu').find('.wrap-menu-inner').slideUp();
								} else {
									$this.removeClass('is-sticky');
									$this.removeClass('no-active-sticky');
									$sidebar.removeClass('no-active-sticky');
									$this.find('.elementor-widget-clever-site-logo').removeClass('header-is-sticky');
									$('.cafe-wrap-menu .toggle .arrow.on-scroll').parents('.cafe-wrap-menu').addClass('toggle-active');
									$('.cafe-wrap-menu .toggle .arrow.on-scroll').parents('.cafe-wrap-menu').find('.wrap-menu-inner').slideDown();
								}
							} else if (current_width < 768.98 && $this.hasClass('mobile-sticky')) {
								if (HeaderTop < top) {
									$this.not('.is-sticky').addClass('is-sticky');
									$this.find('.elementor-widget-clever-site-logo:not(.header-is-sticky)').addClass('header-is-sticky');
									$('.cafe-wrap-menu .toggle .arrow.on-scroll').parents('.cafe-wrap-menu').removeClass('toggle-active');
									$('.cafe-wrap-menu .toggle .arrow.on-scroll').parents('.cafe-wrap-menu').find('.wrap-menu-inner').slideUp();
								} else {
									$this.removeClass('is-sticky');
									$this.removeClass('no-active-sticky');
									$sidebar.removeClass('no-active-sticky');
									$this.find('.elementor-widget-clever-site-logo.header-is-sticky').removeClass('header-is-sticky');
									$('.cafe-wrap-menu .toggle .arrow.on-scroll').parents('.cafe-wrap-menu').addClass('toggle-active');
									$('.cafe-wrap-menu .toggle .arrow.on-scroll').parents('.cafe-wrap-menu').find('.wrap-menu-inner').slideDown();
								}
							}

						});



					});

				}
			},
			post_share: function () {
				$('.post-share .social_label').on('click', function () {
					var parents = $(this).parents('.post-share');
					parents.toggleClass('opened');
					if (parents.hasClass('opened')) {
						parents.find("a").delay(100).each(function (i) {
							$(this).delay(100 * i).queue(function () {
								$(this).addClass("show");
								$(this).dequeue();
							});
						});
					} else {
						parents.find("a").removeClass('show');
					}
				});
			},
			/* ## Theme popup */
			mobile_default: function () {
				$('body').on('click', '.jws-tiger-mobile,.overlay', function () {
					$(this).parents('.elemetor-menu-mobile').toggleClass('active');
				});
			},
			/* ## Theme popup */
			handlePopup: function (data) {
				$(data).each(function () {
					// Activate popup
					$(this).addClass('visible');
					$(this).find('.btn-loading-disabled').addClass('btn-loading');
				});
			},
			scrollTop: function () {
				//Check to see if the window is top if not then display button
				$(window).scroll(function () {
					if ($(this).scrollTop() > 100) {
						$('.backToTop').addClass('totop-show');
					} else {
						$('.backToTop').removeClass('totop-show');
					}
				});
				//Click event to scroll to top
				$('.backToTop').on("click", function () {
					$('html, body').animate({
						scrollTop: 0
					}, 1000);
					return false;
				});
			},
			/**
			 *-------------------------------------------------------------------------------------------------------------------------------------------
			 * video popup
			 *-------------------------------------------------------------------------------------------------------------------------------------------
			 */
			video_popup: function () {


				$(document).on('click', '.video-trailer', function (e) {
					e.preventDefault();
					var $trailer = $(this).attr('href');
					var html = 'no_video';
					if (jwsThemeModule.isYoutubeVideo($trailer)) {
						html = '<iframe src="//www.youtube.com/embed/' + jwsThemeModule.getYouTubeID($trailer) + '?autoplay=1"></iframe>';
					} else if (jwsThemeModule.isVimeoVideo($trailer)) {
						html = '<iframe src="' + $trailer + '?autoplay=1"></iframe>';
					} else {
						html = '<video autoplay playsinline controls><source src="' + $trailer + '" type="video/mp4"></video>';

					}

					$.magnificPopup.open({
						items: {
							src: '<div class="movies-trailer">' + html + '</div>', // can be a HTML string, jQuery object, or CSS selector
							type: 'inline'
						},
						tClose: 'close',
						removalDelay: 360,
						callbacks: {
							beforeOpen: function () {
								this.st.mainClass = 'video-trailer-popup animation-popup';
							},
							open: function () {


							}
						},
					});

				});

				$('.video_format').eq(0).each(function () {
					$('.video_format').magnificPopup({
						delegate: 'a',
						type: 'image',
						removalDelay: 500, //delay removal by X to allow out-animation
						callbacks: {
							beforeOpen: function () {
								this.st.mainClass = 'mfp-zoom-in';
							},
							elementParse: function (item) {
								item.type = 'iframe',
									item.iframe = {
										patterns: {
											youtube: {
												index: 'youtube.com/', // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).
												id: 'v=', // String that splits URL in a two parts, second part should be %id%
												// Or null - full URL will be returned
												// Or a function that should return %id%, for example:
												// id: function(url) { return 'parsed id'; } 
												src: '//www.youtube.com/embed/%id%?autoplay=1' // URL that will be set as a source for iframe. 
											},
											vimeo: {
												index: 'vimeo.com/',
												id: '/',
												src: '//player.vimeo.com/video/%id%?autoplay=1'
											}
										}
									};
							}
						},
					});
				});
			},


			menu_offset: function () {
				var setOffset = function (li, $menu) {

					var $dropdown = li;
					var dropdownWidth = $dropdown.outerWidth();
					var dropdownOffset = $menu.offset();
					var toRight;
					var viewportWidth;
					var dropdownOffset2;
					var dropdownOffsetRight;
					var $dropdown_parent = $dropdown.parents('.elementor-column').offset();
					var before_menu = $dropdown.find('.before-menu');
					viewportWidth = $(document).width();
					if (!dropdownWidth || !dropdownOffset) {
						return;
					}



					dropdownOffsetRight = viewportWidth - dropdownOffset.left - dropdownWidth;

					if ($dropdown.hasClass('mega_menu')) {

						if (viewportWidth < dropdownWidth) {
							$menu.addClass('fullwidth');
							dropdownOffsetRight = - dropdownOffset.left;
						} else {
							$menu.removeClass('fullwidth');
						}

						if ($dropdown.hasClass('left')) {
							if (dropdownOffsetRight < 0) {
								$dropdown.css({
									left: dropdownOffsetRight
								});
							} else {
								$dropdown.css({
									left: 0
								});
							}


						}


						dropdownOffset2 = $dropdown.offset();

						before_menu.css({
							left: $menu.find('> a > span').offset().left - dropdownOffset2.left + $menu.find('> a > span').outerWidth() / 2
						});

						if ($dropdown.hasClass('center')) {
							let item_offsect = -dropdownWidth / 2 + $menu.outerWidth() / 2;
							$dropdown.css({
								left: item_offsect
							});

						}

					}

				};
				$('.elementor_jws_menu_layout_menu_horizontal li.menu-item-design-mega_menu_full_width , .elementor_jws_menu_layout_menu_horizontal li.menu-item-design-mega_menu').each(function () {
					var $menu = $(this);
					$menu.find(' > .sub-menu-dropdown').each(function () {
						setOffset($(this), $menu);
					});
				});
			},
			menu_mobile: function () {
				var dropDownCat = $(".elementor_jws_menu_layout_menu_vertical .menu-item-has-children ,.elementor_jws_menu_layout_menu_vertical .menu_has_shortcode"),
					elementIcon = '<button class="btn-sub-menu jws-icon-caret-down"></button>';
				$(elementIcon).appendTo(dropDownCat.find('> a'));
				if (dropDownCat.hasClass("active")) {
					dropDownCat.addClass("active");
				}
				$(document).on("click", ".btn-sub-menu", function (e) {
					e.preventDefault();


					$(this).parent().parent().siblings().removeClass('active');
					$(this).parent().parent().siblings().find("> ul,.sub-menu-dropdown").slideUp(320);

					$(this).parent().parent().find("> ul").slideToggle(320);
					$(this).parent().parent().find(".sub-menu-dropdown").slideToggle(320);


					if ($(this).parent().parent().hasClass('active')) {
						$(this).parent().parent().removeClass('active');

					} else {
						$(this).parent().parent().addClass('active');
					}
				});
			},
			events_click_hover: function () {

				$('.jws-open-login:not(.logged) , .user-not-logged-in .jws_account , .user-not-logged-in .pmpro-plan-button a , .must-log-in a ').on('click', function (e) {
					event.preventDefault();
					$('.jws-form-login-popup').addClass('open');
					$('.jws-offcanvas').removeClass('jws-offcanvas-show');
					$('.jws-offcanvas-trigger').removeClass('active');
				});

				$('.user-not-logged-in .pmpro-plan-button a , .jws-history-login a').on('click', function (e) {
					var href = $(this).attr('href');
					if (!$('.jws-form-login-popup form').find('[name="redirect"]').length) {
						$('.jws-form-login-popup form').append('<input type="hidden" name="redirect" value="' + href + '">');
					} else {
						$('.jws-form-login-popup form input[name="redirect"]').val(href);
					}
				});


				$('.jws-close , .jws-form-overlay').on('click', function (e) {
					$('.jws-form-login-popup').removeClass('open');
				});
				$('.jws_toolbar_search').on('click', function (e) {
					e.preventDefault();
					$('.form_content_popup').addClass('open');
				});
				$('.close-form').on('click', function (e) {
					e.preventDefault();
					$('.form_content_popup').removeClass('open');
				});
				$('.jws-menu-side .menu-expand').on('click', function (e) {
					e.preventDefault();
					$('body').toggleClass('menu-expand');
				});



			},
			login_form: function () {
				$(window).on('load', function () {
					if (typeof grecaptcha !== "undefined") {
						var recaptcha1 = grecaptcha.render('jwsg-recaptcha', {
							'sitekey': jws_recapcha.google_capcha_site_key,
							'theme': 'light'
						});
					}
				});
				function checkForInput(element, $check) {

					const $label = $(element).parents('.form-row');

					if ($(element).val().length > 0 || $check) {
						$label.addClass('entering_text');
					} else {
						$label.removeClass('entering_text');
					}
				}

				// The lines below are executed on page load
				$('.jws-animation .input').each(function () {
					checkForInput(this, false);
				});

				// The lines below (inside) are executed on change & keyup
				$('.jws-animation .input').on('change keyup focus', function () {
					checkForInput(this, true);
				});

				$('.jws-animation .input').on('focus',
					function () {
						checkForInput(this, true);
					}).on('focusout', function () {
						checkForInput(this, false);
					});



				$('.jws-login-form').each(function () {

					var $this = $(this);

					$this.find('.form-contaier').owlCarousel({
						items: 1,
						touchDrag: false,
						mouseDrag: false
					});

					$(this).find('form[name=loginpopopform]').on('submit', function (event) {
						event.preventDefault();

						var valid = true,
							email_valid = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
						$(this).find('input.required').each(function () {
							// Check empty value
							if (!$(this).val()) {
								$(this).addClass('invalid');
								valid = false;
							}
							// Uncheck
							if ($(this).is(':checkbox') && !$(this).is(':checked')) {
								$(this).addClass('invalid');
								valid = false;
							}
							// Check email format
							if ('email' === $(this).attr('type')) {
								if (!email_valid.test($(this).val())) {
									$(this).addClass('invalid');
									valid = false;
								}
							}
						});
						$(this).find('input.required').on('focus', function () {
							$(this).removeClass('invalid');
						});
						if (!valid) {
							return valid;
						}
						var form = $(this),
							$elem = $this.find('.jws-login-container'),
							wp_submit = $elem.find('input[type=submit]').val();
						if (!$elem.find('> .loader').length) {
							$elem.append('<div class="loader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/></svg></div>');
						}
						$elem.addClass('loading');
						$elem.find('.jws-login .popup-message').slideUp();
						$elem.find('.message').slideDown().remove();
						var data = {
							action: 'jws_login_ajax',
							data: form.serialize() + '&wp-submit=' + wp_submit,
						};

						$.ajax({
							url: jws_script.ajax_url,
							data: data,
							method: 'POST',

							success: function (response) {

								if (response.data.code == '1') {
									if (response.data.redirect) {
										if (window.location.href == response.data.redirect) {
											location.reload();
										} else {
											window.location.href = response.data.redirect;
										}
									} else {
										location.reload();
									}

								}

								$elem.removeClass('loading');

								if (response.success) {
									jwsThemeModule.show_notification(response.data.message, 'success');
								} else {
									jwsThemeModule.show_notification(response.data[0].message, 'error');
									if (typeof grecaptcha !== "undefined") {
										grecaptcha.reset();
									};
								}
							},
							error: function () {
								jwsThemeModule.show_notification('There is a problem with the internet connection, please try again.', 'error');
								$elem.removeClass('loading');
							},
							complete: function () { },
						});

						return false;
					});
					$(this).find('form[name=registerformpopup]').on('submit', function (e) {
						e.preventDefault();
						var valid = true,
							email_valid = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
						$(this).find('input.required').each(function () {
							// Check empty value
							if (!$(this).val()) {
								$(this).addClass('invalid');
								valid = false;
							}
							// Uncheck
							if ($(this).is(':checkbox') && !$(this).is(':checked')) {
								$(this).addClass('invalid');
								valid = false;
							}
							// Check email format
							if ('email' === $(this).attr('type')) {
								if (!email_valid.test($(this).val())) {
									$(this).addClass('invalid');
									valid = false;
								}
							}
						});
						$(this).find('input.required').on('focus', function () {
							$(this).removeClass('invalid');
						});
						if (!valid) {
							return valid;
						}
						var $form = $(this),
							data = {
								action: 'jws_register_ajax',
								data: $form.serialize() + '&wp-submit=' + $form.find('input[type=submit]').val(),
								register_security: $form.find('#register_security').val(),
							},
							$elem = $('#jws-login-form .jws-login-container');
						if (!$elem.find('.loader').length) {
							$elem.append('<div class="loader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/></svg></div>');
						}
						$elem.addClass('loading');
						$elem.find('.jws-register .popup-message').slideUp();
						$elem.find('.message').slideDown().remove();

						$.ajax({
							type: 'POST',
							url: jwsThemeModule.jws_script.ajax_url,
							data: data,
							success: function (response) {
								$elem.removeClass('loading');

								if (response.data.code == '1') {
									if (response.data.redirect) {
										if (window.location.href == response.data.redirect) {
											location.reload();
										} else {
											window.location.href = response.data.redirect;
										}
									} else {
										location.reload();
									}
								}

								if (response.success) {
									jwsThemeModule.show_notification(response.data.message, 'success');
								} else {
									jwsThemeModule.show_notification(response.data[0].message, 'error');
								}
							},
						});
					});
					/* Check Strong Passwoed */
					$(this).find('.jws-register input[name="password"]').keyup(function () {
						checkpassword($(this).val());
						$('.slick-list').css('height', 'auto');
					});

					function checkpassword(password) {
						var strength = 0,
							meter = $('.meter'),
							meter_text = $('.text-meter'),
							password_hint = $('.jws-password-hint');
						if (password.match(/[a-z]+/)) {
							strength += 1;
						}
						if (password.match(/[A-Z]+/) && password.length >= 8) {
							strength += 1;
						}
						if (password.match(/[0-9]+/) && password.length >= 12) {
							strength += 1;
						}
						if (password.match(/[$@#&!]+/) && password.length >= 14) {
							strength += 1;
						}
						if (password.length > 0) {
							meter.show();
							password_hint.show();
						} else {
							meter.hide();
							password_hint.hide();
						}
						switch (strength) {
							case 0:
								meter_text.html("");
								meter.attr("meter", "0");
								break;
							case 1:
								meter_text.html(jwsThemeModule.jws_script.metera);
								meter.attr("meter", "1");
								break;
							case 2:
								meter_text.html(jwsThemeModule.jws_script.meterb);
								meter.attr("meter", "2");
								break;
							case 3:
								meter_text.html(jwsThemeModule.jws_script.meterc);
								meter.attr("meter", "3");
								password_hint.hide();
								break;
							case 4:
								meter_text.html(jwsThemeModule.jws_script.meterd);
								meter.attr("meter", "4");
								password_hint.hide();
								break;
						}
					}
					$(this).find('.change-form.login').on('click', function (e) {
						e.preventDefault();
						$this.addClass('in-login');
						$this.removeClass('in-register');
						$this.find('.form-contaier').trigger('to.owl.carousel', 0);
					});
					$(this).find('.change-form.register').on('click', function (e) {
						e.preventDefault();
						$this.removeClass('in-login');
						$this.addClass('in-register');
						$this.find('.form-contaier').trigger('refresh.owl.carousel');
						$this.find('.form-contaier').trigger('to.owl.carousel', 1);

					});
					$(this).find(".toggle-password2").click(function () {
						$(this).toggleClass("pass-slash");
						$(this).parents('form').find('input[type="password"]').addClass('change-type');
						if ($(this).parents('form').find('.change-type').attr("type") == "password") {
							$(this).parents('form').find('.change-type').attr("type", "text");
						} else {
							$(this).parents('form').find('.change-type').attr("type", "password");
						}
					});



					/* Send otp*/
					$('#send_otp').on('click', function () {
						var email = $(this).parents('form').find('[name="user_email"]').val();
						var $this = $(this);
						$this.addClass('loading');
						if (!$this.find('.loader').length) {
							$this.append('<div class="loader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/></svg></div>');
						}

						if ($this.prop('disabled')) return;

						$this.prop('disabled', true);

						$.post(jws_script.ajax_url, {
							action: 'jws_send_otp',
							email: email
						}, function (response) {
							if (response.success) {
								jwsThemeModule.show_notification(response.data.message, 'success');
								$('#otp_section').show();
								startCountdown(300);
								$this.prop('disabled', false);
							} else {
								$this.prop('disabled', false);
								jwsThemeModule.show_notification(response.data.message, 'error');
							}
							$this.removeClass('loading');
						});
					});


					function startCountdown(seconds) {
						var countdown = seconds;
						$('#otp_timer .countdown').text(countdown);
						$('#otp_timer').show();
						$('#resend_otp').prop('disabled', true).show();
						$('#send_otp').hide();
						var timer = setInterval(function () {
							countdown--;
							$('#otp_timer .countdown').text(countdown);
							if (countdown <= 0) {
								clearInterval(timer);

								$('#otp_timer').hide();
								$('#resend_otp').prop('disabled', false);
							}
						}, 1000);
					}

					$('#resend_otp').on('click', function () {
						$('#send_otp').trigger('click');
					});



				});

			},
			menu_nav: function () {
				var mainMenu = $('.elementor_jws_menu_layout_menu_horizontal').find('.nav'),
					lis = mainMenu.find(' > li.menu-item-design-mega_menu');
				mainMenu.on('hover', ' > li.menu-item-design-mega_menu', function () {
					setOffset($(this));
				});
				var setOffset = function (li) {
					var dropdown = li.find(' > .sub-menu-dropdown');
					dropdown.attr('style', '');
					var dropdownWidth = dropdown.outerWidth(),
						dropdownOffset = dropdown.offset(),
						screenWidth = $(window).width(),
						viewportWidth = screenWidth,
						extraSpace = 10;
					if (!dropdownWidth || !dropdownOffset) return;
					if (dropdownOffset.left + dropdownWidth >= viewportWidth && li.hasClass('menu-item-design-mega_menu')) {
						// If right point is not in the viewport
						var toRight = dropdownOffset.left + dropdownWidth - viewportWidth;
						dropdown.css({
							left: -toRight - extraSpace
						});
					}
				};
				lis.each(function () {
					setOffset($(this));
					$(this).addClass('with-offsets');
				});
				//mega menu  
				var mega_item = mainMenu.find(' > li.menu-item-design-mega_menu_full_width');
				if (mega_item.length > 0) {
					$('.jws_header').addClass('has-mega-full');
				}
				if ($('.elementor_jws_menu_layout_menu_horizontal').hasClass('elementor-jws-menu-change-background-yes')) {
					mega_item.mouseenter(function () {
						$('.jws_header.has-mega-full').addClass('mega-has-hover');
					});
					mega_item.mouseleave(function () {
						$('.jws_header.has-mega-full').removeClass('mega-has-hover');
					});
				}
			},

		};
	}());
	$(document).ready(function () {
		jwsThemeModule.init();
	});
	$.fn.isInViewport = function (custom_space) {
		let elementTop = $(this).offset().top + custom_space;
		let elementBottom = elementTop + $(this).outerHeight();
		let viewportTop = $(window).scrollTop();
		let viewportBottom = viewportTop + $(window).height();

		return elementBottom > viewportTop && elementTop < viewportBottom;
	};

	$(window).on("resize", function (e) {
		jwsThemeModule.menu_offset();
	});


	$.fn.gallery_popup = function (option) {
		if (typeof ($.fn.magnificPopup) == 'undefined') return;
		option.find('a.jws-popup-global').magnificPopup({
			type: 'image',
			gallery: {
				enabled: true
			},
			removalDelay: 500, //delay removal by X to allow out-animation
			mainClass: 'gallery-global mfp-zoom-in mfp-img-mobile',
			callbacks: {
				open: function () {
					//overwrite default prev + next function. Add timeout for css3 crossfade animation
					$.magnificPopup.instance.next = function () {
						var self = this;
						self.wrap.removeClass('mfp-image-loaded');
						setTimeout(function () {
							$.magnificPopup.proto.next.call(self);
						}, 120);
					};
					$.magnificPopup.instance.prev = function () {
						var self = this;
						self.wrap.removeClass('mfp-image-loaded');
						setTimeout(function () {
							$.magnificPopup.proto.prev.call(self);
						}, 120);
					};
				},
				imageLoadComplete: function () {
					var self = this;
					setTimeout(function () {
						self.wrap.addClass('mfp-image-loaded');
					}, 16);
				},
			},
		});
	};


	$.fn.jws_countdown = function (selector) {
		if ($.fn.countdown) {
			var $this = selector,
				untilDate = $this.attr('data-until'),
				compact = $this.attr('data-compact'),
				dateFormat = (!$this.attr('data-format')) ? 'DHMS' : $this.attr('data-format'),
				newLabels = (!$this.attr('data-labels-short')) ?
					['Years', 'Months', 'Weeks', 'Days', 'Hours', 'Minutes', 'Seconds'] :
					['Years', 'Months', 'Weeks', 'Days', 'Hours', 'Mins', 'Secs'],
				newLabels1 = (!$this.attr('data-labels-short')) ?
					['Year', 'Month', 'Week', 'Day', 'Hour', 'Minute', 'Second'] :
					['Year', 'Month', 'Week', 'Day', 'Hour', 'Min', 'Sec'];

			$this.data('countdown') && $this.countdown('destroy');

			if ($(this).hasClass('user-tz')) {
				$this.countdown({
					until: (!$this.attr('data-relative')) ? new Date(untilDate) : untilDate,
					format: dateFormat,
					padZeroes: true,
					compact: compact,
					compactLabels: [' y', ' m', ' w', ' days, '],
					timeSeparator: ' : ',
					labels: newLabels,
					labels1: newLabels1,
					serverSync: new Date($(this).attr('data-time-now'))
				})
			} else {
				$this.countdown({
					until: (!$this.attr('data-relative')) ? new Date(untilDate) : untilDate,
					format: dateFormat,
					padZeroes: true,
					compact: compact,
					compactLabels: [' y', ' m', ' w', ' days, '],
					timeSeparator: ' : ',
					labels: newLabels,
					labels1: newLabels1
				});
			}
		}
	};


})(jQuery);
