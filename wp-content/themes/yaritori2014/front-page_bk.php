<?php get_header(); ?>
		<div id="hero">
			<div class="inner-wrapper">
				<div class="main-copy">
					<h1>見える、つながる、広がる。オープンオフィス社内SNS、[yaritori]。</h1>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>inquire/" class="btn for-desktop">お問い合わせ</a>
				</div>
<!-- 
				<img src="<?php echo get_template_directory_uri(); ?>/images/btn-sound-off.png" class="btn-sound for-desktop" />
 -->
			</div>
<!-- 
			<div id="video-container">
				<video id="video" width="auto" height="auto" loop autoplay preload="true" muted="muted">
					<source src="<?php echo get_template_directory_uri(); ?>/images/sample.mp4" type="video/mp4" />
					<source src="<?php echo get_template_directory_uri(); ?>/images/sample.webm" type="video/webm" />
					<source src="<?php echo get_template_directory_uri(); ?>/images/sample.ogv" type="video/ogg" />
				</video>
			</div>
 -->

			<div class="dummy">
				<img src="<?php echo get_template_directory_uri(); ?>/images/top-hero.jpg" />
			</div>
		</div><!-- #hero -->
		<div id="container">
			<div class="inner-wrapper">
				<ul class="anchor-menu">
					<li class="share"><a href="#share">情報を共有する</a></li>
					<li class="active"><a href="#active">社内が活性化する</a></li>
					<li class="efficient"><a href="#efficient">業務の効率が上がる</a></li>
				</ul>
				<div class="logo-large">
					<img src="<?php echo get_template_directory_uri(); ?>/images/logo-large.gif" alt="yaritoti" />
					<p>シンプルで使いやすい社内SNS｢yaritori」。スタッフ間での情報をリアルタイムで共有し、コミュニケーションを活性化。<br class="for-desktop" />Google APPS との連携で、情報伝達の効率化を実現し、ワークスタイルをアクティブに促進します。</p>
				</div>
			</div>
			<div id="share">
				<img src="<?php echo get_template_directory_uri(); ?>/images/bgd-share-mobile.jpg" alt="" class="bgd-mobile for-mobile" />
				<div class="inner-wrapper">
					<img src="<?php echo get_template_directory_uri(); ?>/images/bgd-share.jpg" alt="" class="bgd-desktop for-desktop" />
					<div class="alpha-box">
						<img src="<?php echo get_template_directory_uri(); ?>/images/text-share.png" alt="【情報】を共有する。" class="copy" />
						<p>「yaritori」は、誰でもカンタンに使いこなせる社内SNS。大切な情報はタイムラインで流れ去ることな確実に伝達。Google Appsとの連携、各種ファイル形式のアップロードなどにより、様々な情報をリアルタイムに全員で共有することができます。</p>
						<div class="inquire">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>inquire/">お問い合わせ</a>
						</div>
					</div>
				</div>
			</div><!-- #share -->
			<div id="active">
				<img src="<?php echo get_template_directory_uri(); ?>/images/bgd-active-mobile.jpg" alt="" class="bgd-mobile for-mobile" />
				<div class="inner-wrapper">
					<img src="<?php echo get_template_directory_uri(); ?>/images/bgd-active.jpg" alt="" class="bgd-desktop for-desktop" />				
					<div class="alpha-box">
						<img src="<?php echo get_template_directory_uri(); ?>/images/text-active.png" alt="【コミュニケーション】が活性化する。" class="copy" />
						<p>レスポンシブ対応の「yaritori」なら、使用端末を問わず、どこからでも情報の発信と閲覧が可能。必要な時に、必要な場所から、必要な情報を活用することで、コミュニケーションや業務が、より滑らかに活性化していきます。</p>
						<div class="inquire">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>inquire/">お問い合わせ</a>
						</div>
					</div>
				</div>
			</div><!-- #active -->
			<div id="efficient">
				<img src="<?php echo get_template_directory_uri(); ?>/images/bgd-efficient-mobile.jpg" alt="" class="bgd-mobile for-mobile" />
				<div class="inner-wrapper">
					<img src="<?php echo get_template_directory_uri(); ?>/images/bgd-efficient.jpg" alt="" class="bgd-desktop for-desktop" />				
					<div class="alpha-box">
						<img src="<?php echo get_template_directory_uri(); ?>/images/text-efficient.png" alt="【業務】の効率があがる。" class="copy" />
						<p>「yaritori」の活用によってミーティングの削減や、ペーパーレス化などが実現。また「yaritori」での活動を自動集計し、人事管理や日常業務の意見集約に活用することもでき、社内業務や会社経営の効率化をトータルに支援します。</p>
						<div class="inquire">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>inquire/">お問い合わせ</a>
						</div>
					</div>
				</div>
			</div><!-- #efficient -->
		</div>
<?php get_footer(); ?>