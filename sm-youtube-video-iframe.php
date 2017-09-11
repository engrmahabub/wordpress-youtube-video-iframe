<?php 
/*
Plugin Name: SM Youtube Video iFrame
Plugin URI: https://github.com/engrmahabub/wordpress-youtube-video-iframe
Author: Mahabubur Rahman
Author URI: http://mahabub.me
Description: Youtube video iframe plugin for wordpress
Version: 1.0.0
*/

class SMYouTubeVideoiFrame_Widget extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array( 
			'classname' => 'SMYouTubeVideoiFrame_Widget',
			'description' => 'SM YouTube channel Video iFrame',
		);
		parent::__construct( 'SMYouTubeVideoiFrame_Widget', 'SM YouTube Video iFrame', $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		// outputs the content of the widget
		extract( $args );
     
	    $title      	= apply_filters( 'widget_title', $instance['title'] );
        $videoId    	= ($instance['videoId'])?$instance['videoId']:'QNUSIOMb6vI';
	    $height    		= ($instance['height'])?$instance['height']:390;
	    $width    		= ($instance['width'])?$instance['width']:640;
	    echo $before_widget;	     
	    if ( $title ) {
	        echo $before_title . $title . $after_title;
	    }	                         
	    // echo $theme;	    
		?>
            <div id="player"></div>
            <script>
                // 2. This code loads the IFrame Player API code asynchronously.
                var tag = document.createElement('script');

                tag.src = "https://www.youtube.com/iframe_api";
                var firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

                // 3. This function creates an <iframe> (and YouTube player)
                //    after the API code downloads.
                var player;
                function onYouTubeIframeAPIReady() {
                    player = new YT.Player('player', {
                        height: '<?=$height;?>',
                        width: '<?=$width;?>',
                        videoId: '<?=$videoId;?>',
                        events: {
                            'onReady': onPlayerReady,
                            'onStateChange': onPlayerStateChange
                        }
                    });
                }

                // 4. The API will call this function when the video player is ready.
                function onPlayerReady(event) {
                    event.target.playVideo();
                }

                // 5. The API calls this function when the player's state changes.
                //    The function indicates that when playing a video (state=1),
                //    the player should play for six seconds and then stop.
                var done = false;
                function onPlayerStateChange(event) {
                    if (event.data == YT.PlayerState.PLAYING && !done) {
                        setTimeout(stopVideo, 6000);
                        done = true;
                    }
                }
                function stopVideo() {
                    player.stopVideo();
                }
            </script>
		<?php
		echo $after_widget;
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		// outputs the options form on admin
		$title      	= esc_attr( $instance['title'] );
    	$videoId    	= esc_attr( $instance['videoId'] );
    	$height    	    = esc_attr( $instance['height'] );
    	$width    	    = esc_attr( $instance['width'] );
    	?>
    	<p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	    </p>
	    <p>
	        <label for="<?php echo $this->get_field_id('videoId'); ?>"><?php _e('YouTube Video ID'); ?></label>
	        <input class="widefat" id="<?php echo $this->get_field_id('videoId'); ?>" name="<?php echo $this->get_field_name('videoId'); ?>" type="text" value="<?php echo $videoId; ?>"/>
	    </p>
        <p>
	        <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('YouTube Video Height'); ?></label>
	        <input class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $height; ?>"/>
	    </p>
        <p>
	        <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('YouTube Video Width'); ?></label>
	        <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $width; ?>"/>
	    </p>



	    <?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = $old_instance;
     
	    $instance['title'] 		= strip_tags( $new_instance['title'] );
	    $instance['videoId']    = strip_tags( $new_instance['videoId']);
	    $instance['height'] 	= strip_tags( $new_instance['height'] );
	    $instance['width'] 		= strip_tags( $new_instance['width'] );
	     
	     
	    return $instance;
	}
}

add_action( 'widgets_init', function(){
	register_widget( 'SMYouTubeVideoiFrame_Widget' );
});