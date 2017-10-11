// JavaScript Document
(function() {
    tinymce.PluginManager.add('wpex_timeline_slider', function(editor, url) {
		editor.addButton('wpex_timeline_slider', {
			text: '',
			tooltip: 'Timeline slider',
			id: 'wpex_timeline_slider_id',
			onclick: function() {
				// Open window
				editor.windowManager.open({
					title: 'Timeline slider',
					body: [
						
						{type: 'listbox',
							name: 'style',
							label: 'Style',
							'values': [
								{text: 'Left side', value: ''},
								{text: 'Full Width', value: 'full-width'},
							]
						},
						{type: 'listbox',
							name: 'layout',
							label: 'Layout',
							'values': [
								{text: 'Horizontal', value: 'horizontal'},
								{text: 'Horizontal Steps', value: 'hozsteps'},
								{text: 'Vertical', value: 'vertical'},
							]
						},
						{type: 'textbox', name: 'posttype', label: 'Post type',  value: 'wp-timeline'},
						{type: 'textbox', name: 'count', label: 'Count', value: '6'},
						{type: 'textbox', name: 'ids', label: 'IDs'},
						{type: 'textbox', name: 'taxonomy', label: 'Custom Taxonomy'},
						{type: 'textbox', name: 'cat', label: 'Categories'},
						{type: 'textbox', name: 'tag', label: 'Tags'},
						{type: 'listbox',
							name: 'order',
							label: 'Order',
							'values': [
								{text: 'Descending', value: 'DESC'},
								{text: 'Ascending', value: 'ASC'}
							]
						},
						{type: 'listbox', 
							name: 'orderby', 
							label: 'Order by', 
							'values': [
								{text: 'Date', value: 'date'},
								{text: 'ID', value: 'ID'},
								{text: 'Author', value: 'author'},
								{text: 'Title', value: 'title'},
								{text: 'Name', value: 'name'},
								{text: 'Modified', value: 'modified'},
								{text: 'Parent', value: 'parent'},
								{text: 'Random', value: 'rand'},
								{text: 'Comment count', value: 'comment_count'},
								{text: 'Menu order', value: 'menu_order'},
								{text: 'Meta value', value: 'meta_value'},
								{text: 'Meta value num', value: 'meta_value_num'},
								{text: 'Post__in', value: 'post__in'},
								{text: 'None', value: 'none'}
							]
						},
						{type: 'textbox', name: 'meta_key', label: 'Meta key (Name of meta key for ordering)'},
						{type: 'listbox',
							name: 'autoplay',
							label: 'Autoplay',
							'values': [
								{text: 'No', value: ''},
								{text: 'Yes', value: '1'}
							]
						},

						{type: 'listbox',
							name: 'show_media',
							label: 'Show media',
							'values': [
								{text: 'Yes', value: '1'},
								{text: 'No', value: '0'},
								
							]
						},

						{type: 'listbox',
							name: 'show_label',
							label: 'Show label',
							'values': [
								{text: 'No', value: '0'},
								{text: 'Yes', value: '1'}
							]
						},
						{type: 'listbox',
							name: 'full_content',
							label: 'Show full Content',
							'values': [
								{text: 'No', value: '0'},
								{text: 'Yes', value: '1'}
							]
						},
						{type: 'listbox',
							name: 'hide_thumb',
							label: 'Hide thubnails',
							'values': [
								{text: 'No', value: '0'},
								{text: 'Yes', value: '1'}
							]
						},
						{type: 'listbox',
							name: 'show_all',
							label: 'Show all items',
							'values': [
								{text: 'No', value: '0'},
								{text: 'Yes', value: '1'}
							]
						},
						{type: 'listbox',
							name: 'arrow_position',
							label: 'Arrow buttons position',
							'values': [
								{text: 'Center', value: ''},
								{text: 'Top', value: 'top'}
							]
						},
						{type: 'listbox',
							name: 'toolbar_position',
							label: 'Timeline bar position',
							'values': [
								{text: 'Top', value: 'top'},
								{text: 'Bottom', value: 'bottom'}
							]
						},
						{type: 'textbox', name: 'class', label: 'Css Class'},
					],
					onsubmit: function(e) {
						// Insert content when the window form is submitted
						 //var uID =  Math.floor((Math.random()*100)+1);
						 editor.insertContent('[wpex_timeline_slider style="' + e.data.style + '" layout="' + e.data.layout + '" posttype="' + e.data.posttype + '" count="' + e.data.count + '" ids="' + e.data.ids + '"   cat="' + e.data.cat + '"  tag="' + e.data.tag + '"  order="' + e.data.order + '"  orderby="' + e.data.orderby + '" meta_key="' + e.data.meta_key + '" taxonomy="' + e.data.taxonomy + '" autoplay="' + e.data.autoplay + '" show_media="' + e.data.show_media + '" full_content="' + e.data.full_content + '" hide_thumb="' + e.data.hide_thumb + '" arrow_position="' + e.data.arrow_position + '" toolbar_position="' + e.data.toolbar_position + '" show_all="' + e.data.show_all + '" class="' + e.data.class + '"]');
					}
				});
			}
		});
	});
})();
