<script>
function zeroPadding( n ) {
	return ( "0" + n ).slice( -2 );
}

function getDatetime( plusDays, hoursMinutes ) {
	var date = new Date();

	if ( typeof( plusDays ) != 'undefined' ) {
		date.setTime( date.getTime() + ( plusDays * 86400000 ) );
	}

	var result = date.getFullYear() + '-'
		+ zeroPadding( date.getMonth() + 1 ) + '-'
		+ zeroPadding( date.getDate() ) + 'T';

	if ( typeof ( hoursMinutes ) == 'undefined' ) {
		result += zeroPadding( date.getHours() ) + ':'
			+ zeroPadding( date.getMinutes() );
	} else {
		result += hoursMinutes;
	}

	return result;
}

function insertEvent() {
	var html = '<article itemscope itemtype="http://schema.org/LiveBlogPosting"><header>';

	if ( document.event_editor.event_name.value != '' ) {
		html += '<h1 itemprop="headline name">' + document.event_editor.event_name.value + '</h1>';
	}

	html += '<p><time datetime="' + getDatetime() + '" itemprop="coverageStartTime"></time>';

	if ( document.event_editor.event_start_time.value != '' ) {
		var eventStartTime = new Intl.DateTimeFormat(
			"<?php echo str_replace( '_', '-', get_locale() ); ?>",
			{
				timeZone: 'UTC',
				year: 'numeric',
				month: 'numeric',
				day: 'numeric',
				hour: 'numeric',
				minute: 'numeric',
				second: 'numeric'
			}
		).format(
			new Date( document.event_editor.event_start_time.value )
		);

		html += '<time itemprop="startDate coverageEndTime" datetime="' + document.event_editor.event_start_time.value + '">' + eventStartTime + '</time>';
	}

	if ( document.event_editor.event_end_time.value != '' ) {
		var eventEndTime = new Intl.DateTimeFormat(
			"<?php echo str_replace( '_', '-', get_locale() ); ?>",
			{
				timeZone: 'UTC',
				year: 'numeric',
				month: 'numeric',
				day: 'numeric',
				hour: 'numeric',
				minute: 'numeric',
				second: 'numeric'
			}
		).format(
			new Date( document.event_editor.event_end_time.value )
		);

		html += '<time itemprop="endDate" datetime="' + document.event_editor.event_end_time.value + '">' + eventEndTime + '</time>';
	}

	html += '</p></header>';

	if ( document.event_editor.event_info.value != '' ) {
		html += '<p itemprop="articleBody">' + document.event_editor.event_info.value + '</p>';
	}

	html += '</article>';

	top.tinymce.activeEditor.selection.setContent( html );
	top.tinymce.activeEditor.windowManager.close();

	return false;
};
</script>
<style>
	#event-editor ul {
		list-style: none;
		padding: 0;
	}

	#event-editor ul li {
		margin-bottom: 1em;
	}

	#event-editor label {
		color: #23282d;
		display: block;
	}

	#event-editor label small {
		font-size: .8em;
		margin-left: 1em;
	}

	#event-editor label + * {
		border-radius: .5em;
		padding: .5em;
		width: 100%;
	}

	#event-editor > ul > li:nth-child(2),
	#event-editor > ul > li:nth-child(3) {
		display: inline-block;
		width: calc( 50% - 3px );
	}

	#event_info {
		height: 7em;
	}
</style>
<form id="event-editor" name="event_editor" onsubmit="insertEvent();">
<ul>
  <li>
	<label for="event_name"><?php echo graftee_get_admin_word( 'event-name' ); ?></label>
	<input type="text" id="event_name" name="event_name" required>
  </li>
  <li>
	<label for="event_start_time"><?php echo graftee_get_admin_word( 'start-time' ); ?><small>(ex.2015-12-03T19:00)</small></label>
	<input type="datetime-local" id="event_start_time" name="event_start_time">
  </li>
  <li>
	<label for="event_end_time"><?php echo graftee_get_admin_word( 'end-time' ); ?></label>
	<input type="datetime-local" id="event_end_time" name="event_end_time">
  </li>
  <li>
	<label for="event_info"><?php echo graftee_get_admin_word( 'event-info' ); ?></label>
	<textarea id="event_info" name="event_info" required></textarea>
  </li>
</ul>

<p><?php echo graftee_get_admin_word( 'event-message' ); ?></p>

<input type="submit" id="submit" value="<?php echo graftee_get_admin_word( 'export' ); ?>">
</form>
<script>
	document.event_editor.event_start_time.value = getDatetime( 7, '10:00' );
	document.event_editor.event_end_time.value = getDatetime( 30, '21:00' );
</script>
