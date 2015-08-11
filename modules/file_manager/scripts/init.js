/**
 * @tableofcontents
 *
 * 1. file manager
 *
 * @since 2.0.0
 *
 * @package Redaxscript
 * @author Henry Ruhs
 */

/* @section 1. file manager */

rs.modules.fileManager =
{
	init: rs.registry.adminParameter === 'file-manager',
	selector: 'form.js_form_file_manager',
	options:
	{
		element:
		{
			fieldFile: 'input.js_file',
			buttonUpload: 'button.js_upload'
		},
		className:
		{
			buttonBrowse: 'js_browse button_admin'
		}
	}
};
