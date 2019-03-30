<div class="wrap apps-container">
<!--
    <?php foreach ($notices as $notice): ?>

        <div class="nf-addon-notice">
            <p>
                <strong><?php echo $notice[ 'title' ]; ?></strong> <?php _e( ' requires an update. You have version ', 'ninja-forms' );?><strong><?php echo $notice[ 'old_version' ]; ?></strong><?php _e( ' installed. The current version is ', 'ninja-forms' ); ?><strong><?php echo $notice[ 'new_version' ]; ?></strong>.
            </p>
        </div>

    <?php endforeach; ?>
-->
    <?php
    $u_id = get_option( 'nf_aff', false );
    if ( !$u_id ) $u_id = apply_filters( 'ninja_forms_affiliate_id', false );
    ?>

    <?php foreach ($items as $item): ?>

    <?php
        $link = $item[ 'link' ];
        if ( $u_id ) {
            $last_slash = strripos( $link, '/' );
            $link = substr( $link, 0, $last_slash );
            $link =  urlencode( $link );
            $link = 'http://www.shareasale.com/r.cfm?u=' . $u_id . '&b=812237&m=63061&afftrack=&urllink=' . $link;
        }
    ?>

    <div class="nf-extend nf-box">

        <div class="nf-box-inside">

            <img src="<?php echo NF_PLUGIN_URL . $item['image']; ?>" />

            <h2><?php echo $item['title']; ?></h2>

            <div class="nf-extend-content">

                <p><?php echo $item['content']; ?></p>

                <div class="nf-extend-buttons">

                    <?php if( ! empty( $item['docs'] ) ): ?>

                    <a target="_blank" href="<?php echo $item['docs']; ?>" class="nf-button secondary nf-doc-button"><?php _e( 'Docs', 'ninja-forms' ); ?></a>
                    <?php else: ?>

                    <p><a><?php _e( 'Documentation coming soon.', 'ninja-forms' ); ?></a></p>

                    <?php endif; ?>

                    <?php if( ! empty( $item['plugin'] ) && file_exists( WP_PLUGIN_DIR.'/'.$item['plugin'] ) ): ?>

                        <?php if( is_plugin_active( $item['plugin'] ) ): ?>

                        <span class="secondary nf-button"><?php _e( 'Active', 'ninja-forms' ); ?></span>

                        <?php elseif( is_plugin_inactive( $item['plugin'] ) ): ?>

                        <span class="secondary nf-button"><?php _e( 'Installed', 'ninja-forms' ); ?></span>

                        <?php else: ?>

                        <a target="_blank" href="<?php echo $link; ?>" title="<?php echo $item['title']; ?>" class="primary nf-button"><?php _e( 'Learn More', 'ninja-forms' ); ?></a>

                        <?php endif; ?>

                    <?php else: ?>

                    <a target="_blank" href="<?php echo $link; ?>" title="<?php echo $item['title']; ?>" class="primary nf-button"><?php _e( 'Learn More', 'ninja-forms' ); ?></a>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

    <?php endforeach; ?>

</div>
