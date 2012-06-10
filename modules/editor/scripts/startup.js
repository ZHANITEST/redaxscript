/* editor */

r.module.editor =
	{
		startup: 1,
		selector: 'textarea.js_editor',
		options:
		{
			control: ['toggle', 'divider', 'bold', 'italic', 'underline', 'strike', 'divider', 'superscript', 'subscript', 'divider', 'paragraph', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'newline', 'ordered_list', 'unordered_list', 'divider', 'outdent', 'indent', 'divider', 'align_left', 'align_center', 'align_right', 'align_justify', 'newline', 'undo', 'redo', 'divider', 'insert_image', 'insert_link', 'unlink', 'divider', 'cut', 'copy', 'paste', 'divider', 'insert_break', 'insert_code', 'insert_function', 'divider', 'unformat'],
			xhtml: true,
			newline: true
		},
		controls:
		{
			toggle:
			{
				title: l.editor_source_code,
				methode: 'toggle'
			},
			bold:
			{
				title: l.editor_bold,
				methode: 'action',
				command: 'bold'
			},
			italic:
			{
				title: l.editor_italic,
				methode: 'action',
				command: 'italic'
			},
			underline:
			{
				title: l.editor_underline,
				methode: 'action',
				command: 'underline'
			},
			strike:
			{
				title: l.editor_strike,
				methode: 'action',
				command: 'strikeThrough'
			},
			superscript:
			{
				title: l.editor_superscript,
				methode: 'action',
				command: 'superscript'
			},
			subscript:
			{
				title: l.editor_subscript,
				methode: 'action',
				command: 'subscript'
			},
			paragraph:
			{
				title: l.editor_paragraph,
				methode: 'format',
				command: 'p'
			},
			h1:
			{
				title: l.headline,
				methode: 'format',
				command: 'h1'
			},
			h2:
			{
				title: l.headline,
				methode: 'format',
				command: 'h2'
			},
			h3:
			{
				title: l.headline,
				methode: 'format',
				command: 'h3'
			},
			h4:
			{
				title: l.headline,
				methode: 'format',
				command: 'h4'
			},
			h5:
			{
				title: l.headline,
				methode: 'format',
				command: 'h5'
			},
			h6:
			{
				title: l.headline,
				methode: 'format',
				command: 'h6'
			},
			ordered_list:
			{
				title: l.editor_ordered_list,
				methode: 'action',
				command: 'insertOrderedList'
			},
			unordered_list:
			{
				title: l.editor_unordered_list,
				methode: 'action',
				command: 'insertUnorderedList'
			},
			outdent:
			{
				title: l.editor_outdent,
				methode: 'action',
				command: 'outdent'
			},
			indent:
			{
				title: l.editor_indent,
				methode: 'action',
				command: 'indent'
			},
			align_left:
			{
				title: l.editor_align_left,
				methode: 'action',
				command: 'justifyLeft'
			},
			align_center:
			{
				title: l.editor_align_center,
				methode: 'action',
				command: 'justifyCenter'
			},
			align_right:
			{
				title: l.editor_align_right,
				methode: 'action',
				command: 'justifyRight'
			},
			align_justify:
			{
				title: l.editor_align_justify,
				methode: 'action',
				command: 'justifyFull'
			},
			undo:
			{
				title: l.editor_undo,
				methode: 'action',
				command: 'undo'
			},
			redo:
			{
				title: l.editor_redo,
				methode: 'action',
				command: 'redo'
			},
			insert_image:
			{
				title: l.editor_insert_image,
				methode: 'insert',
				command: 'insertImage',
				message: l.editor_insert_image,
				value: 'http://'
			},
			insert_link:
			{
				title: l.editor_insert_link,
				methode: 'insert',
				command: 'createLink',
				message: l.editor_insert_link,
				value: 'http://'
			},
			unlink:
			{
				title: l.editor_remove_link,
				methode: 'action',
				command: 'unlink'
			},
			cut:
			{
				title: l.editor_cut,
				methode: 'action',
				command: 'cut'
			},
			copy:
			{
				title: l.editor_copy,
				methode: 'action',
				command: 'copy'
			},
			paste:
			{
				title: l.editor_paste,
				methode: 'action',
				command: 'paste'
			},
			insert_break:
			{
				title: l.editor_insert_document_break,
				methode: 'insertBreak'
			},
			insert_code:
			{
				title: l.editor_insert_code_quote,
				methode: 'insertCode'
			},
			insert_function:
			{
				title: l.editor_insert_php_function,
				methode: 'insert',
				command: 'insertFunction',
				message: l.editor_insert_php_function,
				value: 'function|parameter'
			},
			unformat:
			{
				title: l.editor_remove_format,
				methode: 'action',
				command: 'removeFormat'
			}
		}
	};