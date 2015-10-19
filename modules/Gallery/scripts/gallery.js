/**
 * @tableofcontents
 *
 * 1. gallery
 *    1.1 preload
 *    1.2 open
 *    1.3 resize
 *    1.4 create control
 *    1.5 create meta
 *    1.6 listen
 *    1.7 action
 *       1.7.1 previous
 *       1.7.2 next
 *    1.8 close
 *    1.9 init
 * 2. init
 *
 * @since 2.0.2
 *
 * @package Redaxscript
 * @author Henry Ruhs
 */

(function ($)
{
	'use strict';

	/* @section 1. gallery */

	$.fn.gallery = function (options)
	{
		/* extend options */

		if (rs.modules.gallery.options !== options)
		{
			options = $.extend({}, rs.modules.gallery.options, options || {});
		}

		/* return this */

		return this.each(function ()
		{
			var gallery =
				{
					links: $(this)
				};

			/* @section 1.1 preload */

			gallery.preload = function ()
			{
				gallery.links.each(function ()
				{
					var link = $(this).addClass(options.className.galleryLoader),
						url = link.attr('href'),
						image = $('<img src="' + url + '" />');

					/* image loaded */

					image.on('load', function ()
					{
						link.removeClass(options.className.galleryLoader);
					});
				});
			};

			/* @section 1.2 open */

			gallery.open = function (link, mode)
			{
				var url = link.attr('href'),
					image = $('<img src="' + url + '" />'),
					timeoutLoad = '';

				/* data */

				gallery.data =
				{
					counter: link.data('counter'),
					total: link.data('total'),
					id: link.data('id'),
					artist: link.data('data-artist') || '',
					date: link.data('date') || '',
					description: link.data('description') || ''
				};

				/* gallery related */

				gallery.related = $('#' + gallery.data.id);

				/* add loader */

				if (options.loader)
				{
					gallery.container.addClass(options.className.galleryLoader);
				}

				/* append to body */

				gallery.container.appendTo('body');

				/* initial open */

				if (!mode)
				{
					gallery.overlay.appendTo('body');
					rs.flags.modal = true;
				}

				/* listen for load */

				image.addClass(options.className.galleryMedia).on('load', function ()
				{
					clearTimeout(timeoutLoad);

					/* remove loader */

					if (options.loader)
					{
						gallery.container.removeClass(options.className.galleryLoader);
					}
					gallery.container.html(image);

					/* resize */

					gallery.resize();

					/* create control and meta */

					if (gallery.data.total > 1)
					{
						gallery.createControl();
					}
					gallery.createMeta();
				})

				/* stop propagation */

				.on('click', function (event)
				{
					event.stopPropagation();
				});

				/* close after timeout */

				timeoutLoad = setTimeout(function ()
				{
					gallery.close();
				}, options.timeout);
			};

			/* @section 1.3 resize */

			gallery.resize = function ()
			{
				var win = $(window),
					winHeight = win.height(),
					winWidth = win.width(),
					image = gallery.container.children('img'),
					imageHeight = image.data('height') || image.height(),
					imageWidth = image.data('width') || image.width(),
					galleryHeight = '',
					galleryWidth = '';

				/* store image dimensions */

				image.data(
				{
					'height': imageHeight,
					'width': imageWidth
				});

				/* calculate dimensions */

				if (imageHeight > winHeight)
				{
					imageWidth = imageWidth * winHeight * options.scaling / imageHeight;
					imageHeight = winHeight * options.scaling;
				}
				if (imageWidth > winWidth)
				{
					imageHeight = imageHeight * winWidth * options.scaling / imageWidth;
					imageWidth = winWidth * options.scaling;
				}

				/* adjust image dimensions */

				image.css(
				{
					'height': imageHeight,
					'width': imageWidth
				});

				/* get gallery dimensions */

				galleryHeight = gallery.container.outerHeight();
				galleryWidth = gallery.container.outerWidth();

				/* adjust gallery offset */

				gallery.container.css(
				{
					'margin-top': -galleryHeight / 2,
					'margin-left': -galleryWidth / 2
				});
			};

			/* @section 1.4 create control */

			gallery.createControl = function ()
			{
				/* previous control */

				gallery.buttonPrevious = $('<a>' + rs.language._gallery.image_previous + '</a>').addClass(options.className.controlPrevious)

				/* listen for click */

				.one('click', function (event)
				{
					gallery.previous();
					event.stopPropagation();
				}).appendTo(gallery.container);

				/* next control */

				gallery.buttonNext = $('<a>' + rs.language._gallery.image_next + '</a>').addClass(options.className.controlNext)

				/* listen for click */

				.one('click', function (event)
				{
					gallery.next();
					event.stopPropagation();
				}).appendTo(gallery.container);
			};

			/* @section 1.5 create meta */

			gallery.createMeta = function ()
			{
				gallery.meta = $('<div>').addClass(options.className.galleryMeta);

				/* artist */

				if (gallery.data.artist)
				{
					gallery.artist = $('<div data-label="' + rs.language._gallery.image_artist + '">' + gallery.data.artist + '</div>').addClass(options.className.galleryArtist).appendTo(gallery.meta);
				}

				/* date */

				if (gallery.data.date)
				{
					gallery.date = $('<div data-label="' + rs.language.date + '">' + gallery.data.date + '</div>').addClass(options.className.galleryDate).appendTo(gallery.meta);
				}

				/* description */

				if (gallery.data.description)
				{
					gallery.description = $('<div data-label="' + rs.language._gallery.image_description + '">' + gallery.data.description + '</div>').addClass(options.className.galleryDescription).appendTo(gallery.meta);
				}

				/* pagination */

				if (gallery.data.total > 1)
				{
					gallery.pagination = $('<div>' + gallery.data.counter + rs.language._gallery.divider + gallery.data.total + '</div>').addClass(options.className.galleryPagination).appendTo(gallery.meta);
				}

				/* append meta */

				gallery.meta.appendTo(gallery.container);
			};

			/* @section 1.6 listen */

			gallery.listen = function ()
			{
				/* listen for click */

				gallery.links.on('click', function (event)
				{
					var link = $(this);

					gallery.open(link);
					event.preventDefault();
				});

				/* listen for keydown */

				$(window).on('keydown', function (event)
				{
					if (rs.flags.modal)
					{
						/* trigger close action */

						if (event.which === 27)
						{
							gallery.close();
						}

						/* trigger previous action */

						if (event.which === 37)
						{
							gallery.previous();
						}

						/* trigger next action */

						if (event.which === 39)
						{
							gallery.next();
						}

						/* disable cursors */

						if (event.which > 36 && event.which < 41)
						{
							event.preventDefault();
						}
					}
				})

				/* listen for resize */

				.on('resize', function ()
				{
					if (rs.flags.modal)
					{
						gallery.resize();
					}
				});

				/* listen for click */

				gallery.overlay.on('click', function ()
				{
					gallery.close();
				});
			};

			/* @section 1.7 action */

			gallery.action = function (mode)
			{
				var related = gallery.related,
					counter = gallery.data.counter,
					link = '';

				/* previous action */

				if (mode === 'previous')
				{
					if (counter === 1)
					{
						counter = gallery.data.total;
					}
					else
					{
						counter--;
					}
				}

				/* next action */

				else if (mode === 'next')
				{
					if (counter === gallery.data.total)
					{
						counter = 1;
					}
					else
					{
						counter++;
					}
				}

				/* close and open gallery */

				if (counter > 1 || counter < gallery.data.total)
				{
					link = related.find('a[data-counter="' + counter + '"]');

					if (link.length)
					{
						gallery.close(mode);
						gallery.open(link, mode);
					}
				}

			};

			/* @section 1.7.1 previous */

			gallery.previous = function ()
			{
				gallery.action('previous');
			};

			/* @section 1.7.2 next */

			gallery.next = function ()
			{
				gallery.action('next');
			};

			/* @section 1.8 close */

			gallery.close = function (mode)
			{
				gallery.data = {};
				gallery.container.empty().detach();

				/* ultimate close */

				if (!mode)
				{
					gallery.overlay.detach();
					rs.flags.modal = false;
				}
			};

			/* @section 1.9 init */

			gallery.init = function ()
			{
				/* data object */

				gallery.data = {};

				/* create gallery elements */

				gallery.overlay = $('<div>').addClass(options.className.galleryOverlay);
				gallery.container = $('<div>').addClass(options.className.gallery);

				/* preload */

				if (options.preload)
				{
					gallery.preload();
				}

				/* listen */

				gallery.listen();
			};

			/* init */

			gallery.init();
		});
	};

	/* @section 2. init */

	$(function ()
	{
		if (rs.modules.gallery.init)
		{
			$(rs.modules.gallery.selector).gallery(rs.modules.gallery.options);
		}
	});
})(window.jQuery || window.Zepto);