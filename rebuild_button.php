<?php
/* Trigger a rebuild of the gatsby website......... */
function create_rebuild_metabox() {
	add_meta_box(
			'switchback_rebuild_gatsby',
			'Gatsby - Rebuild Your Website',
			'rebuild_gatsby_call',
			['post', 'page'],
			'side',
			'high'
	);
}
add_action( 'add_meta_boxes', 'create_rebuild_metabox' );


function rebuild_gatsby_call() {
	global $post;
	// Nonce field to validate form request came from current site
	wp_nonce_field( 'request_send_post_details', 'request_cta_nonce' );
	?>
	<p>Remeber to click the Publish or the Update button first.</p>
	<a href="#" id="rebuild_gatsby_website" class="button button-primary">Rebuild LIVE Website</a>

	<script>
			(function(){
				const wordPressAdminWrap = document.querySelector('#wpwrap');
				const netlifyBuildHook = `#`;
				const builtLink = `#`;
				const rebuildBtn = document.getElementById('rebuild_gatsby_website');
				let module;
				let linkButton;
				let closeButton;
				if(rebuildBtn === null) return;

				function createTheModel() {
        const moduleDiv = `
        <div class="gatsby-build-model">
          <div class="gatsby-build-model-inner">
            <p>The trigger has been sent, it should take between 3~5 minutes for your changes to be seen on the live website. Remember you need to have saved your changes before you can rebuild.</p>
            <a class="button button-secondary" target="_blank" href="${builtLink}">Click to view live Website</a>
            <button class="notice-dismiss" type="button"></button>
            <div class="gatsby-build-model-inner-loader">
              <div class="spinner-wrapper">
                <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
              </div>
              <p>Sending build hook trigger to your live website. Once the trigger have been sent, it should take between 3~5 minutes for your changes to be seen on the live website.</p>
            </div>
          </div>
        </div>
        `
        wordPressAdminWrap.insertAdjacentHTML('afterbegin', moduleDiv);
        module = document.querySelector('.gatsby-build-model')
        linkButton = document.querySelector('.gatsby-build-model a')
        closeButton = document.querySelector('.gatsby-build-model button');
      }
			createTheModel()
			
			function removeTheModule(){
        module.classList.remove('open-preview')
        module.classList.remove('loading')
      }
      
      function activateTheModule() {
        module.classList.add('open-preview')
        module.classList.remove('loading')
      }

      function activateLoader() {
        module.classList.add('open-preview')
        module.classList.add('loading')
			}
			
			async function handlePreviewBuild(e) {
        e.preventDefault();
        const nonce = this.closest('.inside').querySelector('#request_cta_nonce').value;

        if(nonce === undefined) return

        activateLoader();
        
        const response = await fetch(netlifyBuildHook, {
          	method: 'POST',
          });

          if(response.ok) {
            setTimeout(() => {
              activateTheModule();
            }, 2000);
          }
        }

				rebuildBtn.addEventListener("click", handlePreviewBuild)
        closeButton.addEventListener('click', removeTheModule);
        linkButton.addEventListener('click', removeTheModule);

			})()
	</script>
	<?php

}