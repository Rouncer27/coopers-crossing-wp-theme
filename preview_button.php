<?php
/* Build a Preview of the website......... */

function create_preview_metabox() {
	add_meta_box(
			'switchback_preview_gatsby',
			'Gatsby - Build a Preview of Your Website',
			'preview_gatsby_call',
			'post',
			'side',
			'high'
	);
}
add_action( 'add_meta_boxes', 'create_preview_metabox' );

function preview_gatsby_call() {
	global $post;
	wp_nonce_field( 'request_send_post_details', 'request_preview_nonce' );
?>

	<p>Remeber to click the Publish or the Update button first.</p>
	<a href="#" id="rebuild_gatsby_preview_website" class="button button-primary">Build PREVIEW Website</a>

	<script>
    (function(){
      const wordPressAdminWrap = document.querySelector('#wpwrap');
      const previewLink = "#/blog/<?php echo esc_attr( $post->post_name ); ?>";
      const gatsbyCloudWebhook = `#`;
      const previewBtn = document.getElementById('rebuild_gatsby_preview_website');
      let module;
      let linkButton;
      let closeButton;
      if(previewBtn === null) return;

      function createTheModel() {
        const moduleDiv = `
        <div class="gatsby-cloud-preview-model">
          <div class="gatsby-cloud-preview-model-inner">
            <p>Your preview is ready to be viewed. Remember you need to have saved your changes before you can preview.</p>
            <a class="button button-secondary" target="_blank" href="${previewLink}">Click to Preview Website</a>
            <button class="notice-dismiss" type="button"></button>
            <div class="gatsby-cloud-preview-model-inner-loader">
              <div class="spinner-wrapper">
                <div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
              </div>
              <p>Building your preview. Please stand by.</p>
            </div>
          </div>
        </div>
        `
        wordPressAdminWrap.insertAdjacentHTML('afterbegin', moduleDiv);
        module = document.querySelector('.gatsby-cloud-preview-model')
        linkButton = document.querySelector('.gatsby-cloud-preview-model-inner a')
        closeButton = document.querySelector('.gatsby-cloud-preview-model-inner button');
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
        const nonce = this.closest('.inside').querySelector('#request_preview_nonce').value;

        if(nonce === undefined) return

        activateLoader();
        
        const response = await fetch(gatsbyCloudWebhook, {
          	method: 'POST',
          });

          if(response.ok) {
            setTimeout(() => {
              activateTheModule();
            }, 5000);
          }
        }
          
        previewBtn.addEventListener("click", handlePreviewBuild)
        closeButton.addEventListener('click', removeTheModule);
        linkButton.addEventListener('click', removeTheModule);
          
      })()
  </script>
<?php
}