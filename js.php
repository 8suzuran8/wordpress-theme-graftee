<?php
  /**
   * @package graftee
   */
?>
if (window.addEventListener) {
    window.addEventListener('load', grafteeLoader, false);
} else if(window.attachEvent) {
    window.attachEvent('onload', grafteeLoader);
} else {
    window.onload = grafteeLoader;
}

function grafteeLoader() {
	// 文字サイズ変更保存
	var change_font_size = document.querySelectorAll( '[name=change-font-size-button]' );
	for( var i = 0; i < change_font_size.length; i ++ ) {
		change_font_size[ i ].onchange = function() {
			localStorage.setItem( 'graftee-font-size', this.value );
		}
	}

	// CSS4で廃止予定
	var aElems = document.getElementsByTagName('ul');

	for (i in aElems) {
		if (!i.match(/^[0-9]+$/) || typeof(aElems[i].className) == 'undefined' || aElems[i].className != 'sub-menu') continue;

		for (j in aElems[i].children) {
			if (!j.match(/^[0-9]+$/) || typeof(aElems[i].children[j].tagName) == 'undefined' || aElems[i].children[j].tagName.toLowerCase() != 'li') continue;

			for (k in aElems[i].children[j].children) {
				if (!k.match(/^[0-9]+$/) || typeof(aElems[i].children[j].children[k].tagName) == 'undefined' || aElems[i].children[j].children[k].tagName.toLowerCase() != 'a') continue;
				var target = aElems[i].children[j].children[k];

				target.onfocus = function() {
					if (this.parentNode.parentNode.className == 'sub-menu') {
						this.parentNode.parentNode.style.transform="scaleY(1)";
					}

					if (this.parentNode.parentNode.parentNode.parentNode.className == 'sub-menu') {
						this.parentNode.parentNode.parentNode.parentNode.style.transform="scaleY(1)";
					}
				}

				target.onblur = function() {
					if (this.parentNode.parentNode.parentNode.parentNode.className == 'sub-menu') {
						this.parentNode.parentNode.parentNode.parentNode.style.transform="scaleY(0)";
					} else if (this.parentNode.parentNode.className == 'sub-menu') {
						this.parentNode.parentNode.style.transform="scaleY(0)";
					}
				}
			}
		}
	}

	// コメントiframeの高さ調節
	if ( window.self != window.top && !window.parent.document.querySelector( 'iframe[title="Site Preview"]' ) ) {
		document.body.className = document.body.className + ' foriframe';

		var nodes = window.parent.document.querySelectorAll('iframe.foriframe');
		for ( var i = 0; i < nodes.length; i ++ ) {
			if ( window.document.querySelector( 'main > article > ul' ) ) {
				nodes[ i ].style.height = (window.document.querySelector( 'main > article > ul' ).clientHeight + 16) + 'px';
				window.scrollTo( 0, (window.document.querySelector( 'main > article > ul' ).offsetTop + 0) );
			} else {
				nodes[ i ].style.height = (window.document.querySelector( 'main' ).clientHeight + 16) + 'px';
				window.scrollTo( 0, (window.document.querySelector( 'main' ).offsetTop + 0) );
			}
		}

		if ( document.querySelector( 'body > footer > a' ) ) {
			document.querySelector( 'body > footer > a' ).remove();
		}
		if ( document.querySelector( 'body > aside' ) ) {
			document.querySelector( 'body > aside' ).remove();
		}
	}
}
