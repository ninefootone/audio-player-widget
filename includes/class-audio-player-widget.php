<?php
/**
 * Sermon Player Widget for Elementor.
 *
 * @package ChurchSermonsPlayer
 */

namespace ChurchSermonsPlayer;

defined( 'ABSPATH' ) || exit;

class Sermon_Player_Widget extends \Elementor\Widget_Base {

    public function get_name(): string {
        return 'sermon_player';
    }

    public function get_title(): string {
        return esc_html__( 'Sermon Audio Player', 'church-sermons-player' );
    }

    public function get_icon(): string {
        return 'eicon-headphones';
    }

    public function get_categories(): array {
        return [ 'general' ];
    }

    public function get_keywords(): array {
        return [ 'sermon', 'audio', 'player', 'plyr', 'resource' ];
    }

    /**
     * Enqueue Plyr only when this widget is actually present on the page.
     */
    public function get_script_depends(): array {
        return [ 'csp-init' ];
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
                'label' => esc_html__( 'Sermon Audio', 'church-sermons-player' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'acf_field_slug',
            [
                'label'       => esc_html__( 'ACF Field Slug', 'church-sermons-player' ),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => 'resource_audio',
                'description' => esc_html__( 'The ACF field slug that stores the audio attachment ID.', 'church-sermons-player' ),
            ]
        );

        $this->add_control(
            'fallback_message',
            [
                'label'   => esc_html__( 'No Audio Message', 'church-sermons-player' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Audio unavailable for this sermon.', 'church-sermons-player' ),
            ]
        );

        $this->end_controls_section();

        // ── Style ─────────────────────────────────────────────────────────────
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Player Style', 'church-sermons-player' ),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'accent_color',
            [
                'label'     => esc_html__( 'Player Background', 'church-sermons-player' ),
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
                'label'     => esc_html__( 'Button Background', 'church-sermons-player' ),
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
                'label'     => esc_html__( 'Button Icon Colour', 'church-sermons-player' ),
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
                'label'     => esc_html__( 'Button Hover Background', 'church-sermons-player' ),
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
                'label'     => esc_html__( 'Button Hover Icon Colour', 'church-sermons-player' ),
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
                'label'     => esc_html__( 'Progress Bar Colour', 'church-sermons-player' ),
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
                'label'     => esc_html__( 'Volume Bar Colour', 'church-sermons-player' ),
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
                'label'      => esc_html__( 'Border Radius', 'church-sermons-player' ),
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
        $settings   = $this->get_settings_for_display();
        $field_slug = sanitize_key( $settings['acf_field_slug'] ?? 'resource_audio' );

        // get_field() requires ACF to be active.
        if ( ! function_exists( 'get_field' ) ) {
            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                echo '<p>' . esc_html__( 'ACF is not active.', 'church-sermons-player' ) . '</p>';
            }
            return;
        }

        $audio_id  = get_field( $field_slug );
        $audio_url = $audio_id ? wp_get_attachment_url( (int) $audio_id ) : false;

        // ── Editor placeholder when no audio is attached ──────────────────
        if ( ! $audio_url ) {
            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                echo '<div style="padding:1rem;background:#f3f4f6;border-radius:6px;color:#6b7280;font-size:0.875rem;">'
                    . esc_html__( 'Sermon Player: no audio found for field "', 'church-sermons-player' )
                    . esc_html( $field_slug )
                    . '".</div>';
            } else {
                $fallback = $settings['fallback_message'] ?? '';
                if ( $fallback ) {
                    echo '<p class="csp-no-audio">' . esc_html( $fallback ) . '</p>';
                }
            }
            return;
        }

        // ── Player markup ─────────────────────────────────────────────────
        ?>
        <div class="csp-player-wrap">
            <audio
                class="csp-sermon-audio"
                controls
                playsinline
                preload="metadata"
                data-plyr-config='{"controls":["play","progress","current-time","duration","mute","volume"]}'
            >
                <source src="<?php echo esc_url( $audio_url ); ?>" type="audio/mpeg">
                <?php esc_html_e( 'Your browser does not support the audio element.', 'church-sermons-player' ); ?>
            </audio>
        </div>
        <?php
    }

    /**
     * Render a static placeholder in the Elementor editor (no JS execution).
     */
    protected function content_template(): void {
        ?>
        <#
        var fieldSlug = settings.acf_field_slug || 'resource_audio';
        #>
        <div style="padding:1rem;background:#f3f4f6;border-radius:6px;color:#6b7280;font-size:0.875rem;">
            Sermon Player — field: <strong>{{ fieldSlug }}</strong><br>
            <em>Audio will render on the front end.</em>
        </div>
        <?php
    }
}