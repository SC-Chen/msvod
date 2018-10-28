锘?var i = 0,
	got = -1,
	len = document.getElementsByTagName('script').length;
	while (i <= len && got == -1) {
		var js_url = document.getElementsByTagName('script')[i].src,
		got = js_url.indexOf('mflikes.js');
		i++
	}
	var edit_mode = '1',
	mflikes_url = js_url.substr(0, js_url.indexOf('/js/'));
function mflikes(post_id, user_id) {
	if(jQuery('.mflikes-post-' + post_id).hasClass('TAlike')){
		alert('浣犲凡缁忓枩娆㈣繃浜嗗摝~');
		return false;
	}

  if (post_id >= 1) {


      // like button clicked
      jQuery('.mflikes-post-' + post_id).addClass('mflikes-loading');

      jQuery.post(mflikes_url + '/', {
        "post_id": post_id,
        "user_id": user_id
      },
      function(result) {
		
		jQuery('.mflikes-' + post_id + '-number').text(result);

        jQuery('.mflikes-post-' + post_id ).addClass('TAlike').removeClass('mflikes-loading');
      });

  } // end post id check
} // end mflikes
