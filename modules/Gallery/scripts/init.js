/**
 * @tableofcontents
 *
 * 1. gallery
 *
 * @since 2.0.0
 *
 * @package Redaxscript
 * @author Henry Ruhs
 */

/* @section 1. gallery */

rs.modules.gallery =
{
	init: true,
	selector: 'ul.js_list_gallery a',
	options:
	{
		className:
		{
			gallery: 'js_gallery gallery',
			galleryLoader: 'js_gallery_loader gallery_loader',
			galleryMedia: 'js_gallery_media gallery_media',
			galleryMeta: 'js_gallery_meta gallery_meta',
			galleryPagination: 'js_gallery_pagination gallery_pagination',
			galleryArtist: 'js_gallery_artist gallery_artist',
			galleryDate: 'js_gallery_date gallery_date',
			galleryDescription: 'js_gallery_description gallery_description',
			galleryOverlay: 'js_gallery_overlay gallery_overlay',
			controlPrevious: 'js_gallery_previous gallery_control gallery_control_previous',
			controlNext: 'js_gallery_next gallery_control gallery_control_next'
		},
		scaling: 0.92,
		timeout: 10000,
		loader: true,
		preload: true
	}
};

/* mobile */

if (rs.registry.myMobile)
{
	rs.modules.gallery.options.scaling = 0.98;
	rs.modules.gallery.options.loader = false;
	rs.modules.gallery.options.preload = false;
}