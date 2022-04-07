(function() {
	tinymce.create(
		'tinymce.plugins.eventEditor',
		{ 
			init : function( ed,  url) {
				ed.addCommand(
					'event-editor',
					function() {
						ed.windowManager.open(
							{
								url: ajaxurl + '?action=dynamic_modal',
								width: 480,
								height: 400,
								title: 'Event Editor'
							},
							{
								custom_param: 1 
							}
						);
					}
				);
	     
				ed.addButton(
					'event-editor',
					{
						title : 'event editor',
						cmd : 'event-editor',
						icon: 'table'
					}
				);
			},
		}
	);

	tinymce.PluginManager.add('eventEditor', tinymce.plugins.eventEditor);
})();
