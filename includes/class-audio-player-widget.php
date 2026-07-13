<?php
/**
 * Audio Player Widget for Elementor.
 *
 * @package AudioPlayerWidget
 */

namespace AudioPlayerWidget;

defined( 'ABSPATH' ) || exit;

class Audio_Player_Widget extends \Elementor\Widget_Base {

    public function get_name(): string {
        return 'apw_audio_player';
    }

    public function get_title(): string {
        return esc_html__( 'Audio Player', 'audio-player-widget' );
    }

    public function get_icon(): string {
        return 'eicon-headphones';
    }

    public function get_categories(): array {
        return [ 'general' ];
    }

    public function get_keywords(): array {
        return [ 'audio', 'player', 'plyr', 'acf', 'sermon', 'podcast' ];
    }

    public function get_script_depends(): array {
        return [ 'apw-init' ];
    }

    public function get_style_depends(): array {
        return [ 'plyr-css' ];
    }

    // -------------------------------------------------------------------------
    // Controls
    // -------------------------------------------------------------------------

    protected function register_controls(): void {

        // ── Content ──────────────────────────────────────────────────────────
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Audio Source', 'audio-player-widget' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'source_type',
            [
                'label'   => esc_html__( 'Source Type', 'audio-player-widget' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'url',
                'options' => [
                    'url' => esc_html__( 'Direct URL', 'audio-player-widget' ),
                    'acf' => esc_html__( 'ACF Field', 'audio-player-widget' ),
                ],
            ]
        );

        $this->add_control(
            'audio_url',
            [
                'label'       => esc_html__( 'Audio URL', 'audio-player-widget' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => 'https://example.com/audio.mp3',
                'condition'   => [ 'source_type' => 'url' ],
            ]
        );

        $this->add_control(
            'acf_field_slug',
            [
                'label'       => esc_html__( 'ACF Field Slug', 'audio-player-widget' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => 'audio_file',
                'description' => esc_html__( 'The ACF field slug that stores the audio attachment ID.', 'audio-player-widget' ),
                'condition'   => [ 'source_type' => 'acf' ],
            ]
        );

        $this->add_control(
            'fallback_message',
            [
                'label'   => esc_html__( 'No Audio Message', 'audio-player-widget' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Audio unavailable.', 'audio-player-widget' ),
            ]
        );

        $this->add_control(
            'show_speed',
            [
                'label'        => esc_html__( 'Speed Control', 'audio-player-widget' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'audio-player-widget' ),
                'label_off'    => esc_html__( 'Hide', 'audio-player-widget' ),
                'return_value' => 'yes',
                'default'      => '',
                'description'  => esc_html__( 'Adds a settings menu with playback speed options.', 'audio-player-widget' ),
            ]
        );

        $this->add_control(
            'default_speed',
            [
                'label'     => esc_html__( 'Default Speed', 'audio-player-widget' ),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => '1',
                'options'   => [
                    '0.5' => '0.5×',
                    '1'   => '1× (normal)',
                    '1.5' => '1.5×',
                    '2'   => '2×',
                    '3'   => '3×',
                    '5'   => '5×',
                ],
                'condition' => [ 'show_speed' => 'yes' ],
            ]
        );

        $this->end_controls_section();

        // ── Style ─────────────────────────────────────────────────────────────
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Player Style', 'audio-player-widget' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'accent_color',
            [
                'label'     => esc_html__( 'Player Background', 'audio-player-widget' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#f97316',
                'selectors' => [
                    '{{WRAPPER}} .plyr--audio .plyr__controls' => 'background: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label'     => esc_html__( 'Button Background', 'audio-player-widget' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => 'transparent',
                'selectors' => [
                    '{{WRAPPER}} .plyr--audio .plyr__controls button,
                     {{WRAPPER}} .plyr--audio .plyr__controls [type=button]' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label'     => esc_html__( 'Button Icon Colour', 'audio-player-widget' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .plyr--audio .plyr__controls button,
                     {{WRAPPER}} .plyr--audio .plyr__controls [type=button]' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label'     => esc_html__( 'Button Hover Background', 'audio-player-widget' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .plyr--audio .plyr__controls button:hover,
                     {{WRAPPER}} .plyr--audio .plyr__controls button:focus,
                     {{WRAPPER}} .plyr--audio .plyr__controls [type=button]:hover,
                     {{WRAPPER}} .plyr--audio .plyr__controls [type=button]:focus' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'button_hover_icon_color',
            [
                'label'     => esc_html__( 'Button Hover Icon Colour', 'audio-player-widget' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .plyr--audio .plyr__controls button:hover,
                     {{WRAPPER}} .plyr--audio .plyr__controls button:focus,
                     {{WRAPPER}} .plyr--audio .plyr__controls [type=button]:hover,
                     {{WRAPPER}} .plyr--audio .plyr__controls [type=button]:focus' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'progress_color',
            [
                'label'     => esc_html__( 'Progress Bar Colour', 'audio-player-widget' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .plyr' => '--plyr-color-main: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'volume_color',
            [
                'label'     => esc_html__( 'Volume Bar Colour', 'audio-player-widget' ),
                'type'      => \Elementor\Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .plyr--audio .plyr__volume input[type=range]' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'player_border_radius',
            [
                'label'      => esc_html__( 'Border Radius', 'audio-player-widget' ),
                'type'       => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em' ],
                'range'      => [
                    'px' => [ 'min' => 0, 'max' => 32 ],
                ],
                'default'    => [ 'unit' => 'px', 'size' => 8 ],
                'selectors'  => [
                    '{{WRAPPER}} .plyr' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    // -------------------------------------------------------------------------
    // Render
    // -------------------------------------------------------------------------

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        $audio_url = '';

        if ( $settings['source_type'] === 'acf' ) {

            if ( ! function_exists( 'get_field' ) ) {
                if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                    echo '<p>' . esc_html__( 'ACF is not active.', 'audio-player-widget' ) . '</p>';
                }
                return;
            }

            $field_slug = sanitize_key( $settings['acf_field_slug'] ?? 'audio_file' );
            $audio_id   = get_field( $field_slug );
            $audio_url  = $audio_id ? wp_get_attachment_url( (int) $audio_id ) : '';

        } else {

            $audio_url = $settings['audio_url']['url'] ?? '';

        }

        // ── Editor placeholder when no audio is set ───────────────────────
        if ( ! $audio_url ) {
            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                $mode = $settings['source_type'] === 'acf'
                    ? 'ACF field "' . esc_html( $settings['acf_field_slug'] ) . '"'
                    : 'Direct URL';
                echo '<div style="padding:1rem;background:#f3f4f6;border-radius:6px;color:#6b7280;font-size:0.875rem;">'
                    . esc_html__( 'Audio Player: no audio found for ', 'audio-player-widget' )
                    . esc_html( $mode )
                    . '.</div>';
            } else {
                $fallback = $settings['fallback_message'] ?? '';
                if ( $fallback ) {
                    echo '<p class="apw-no-audio">' . esc_html( $fallback ) . '</p>';
                }
            }
            return;
        }

        // ── Build Plyr config ─────────────────────────────────────────────
        $controls = [ 'play', 'progress', 'current-time', 'duration', 'mute', 'volume' ];
        $plyr_config = [ 'controls' => $controls ];

        if ( ( $settings['show_speed'] ?? '' ) === 'yes' ) {
            $controls[]              = 'settings';
            $plyr_config['controls'] = $controls;
            $plyr_config['settings'] = [ 'speed' ];
            $plyr_config['speed']    = [
                'selected' => (float) ( $settings['default_speed'] ?? 1 ),
                'options'  => [ 0.5, 1, 1.5, 2, 3, 5 ],
            ];
        }

        $plyr_config_json = wp_json_encode( $plyr_config );

        // ── Player markup ─────────────────────────────────────────────────
        ?>
        <div class="apw-player-wrap">
            <audio
                class="apw-audio"
                controls
                playsinline
                preload="metadata"
                data-plyr-config='<?php echo esc_attr( $plyr_config_json ); ?>'
            >
                <source src="<?php echo esc_url( $audio_url ); ?>" type="audio/mpeg">
                <?php esc_html_e( 'Your browser does not support the audio element.', 'audio-player-widget' ); ?>
            </audio>
        </div>
        <?php
    }

    /**
     * Render a static placeholder in the Elementor editor.
     */
    protected function content_template(): void {
        ?>
        <#
        var sourceType = settings.source_type || 'url';
        var sourceLabel = sourceType === 'acf' ? 'ACF field: ' + settings.acf_field_slug : 'Direct URL';
        #>
        <div style="padding:1rem;background:#f3f4f6;border-radius:6px;color:#6b7280;font-size:0.875rem;">
            Audio Player — {{ sourceLabel }}<br>
            <em>Audio will render on the front end.</em>
        </div>
        <?php
    }
}
