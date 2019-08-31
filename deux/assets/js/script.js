(function ( $ ) {
	'use strict';

	var deux = deux || {};

	deux.init = function () {
		this.$window = $( window );
		this.$body = $( document.body );
		this.$sideMenu = $( '.side-menu' );

		this.data = deuxData || {};
        
		this.closeTopbar();
		this.menuHover();
		this.toggleSideMenu();
		this.iziModal();
		this.toggleModal();
		this.removeCartItem();
		this.toggleSlide();
		this.focusInputs();
		this.accordionCartItem();
		this.toggleTabs();
		this.filterProducts();
		this.sortProducts();
		this.productQuantity();
		this.productImagesLightbox();
		this.stickyProductSummary();
		this.checkBox();
		this.formatGallery();
		this.backToTop();
		this.fixedFooter();
		this.toggleProductFilter();
		this.productQuickView();
		this.productAttribute();
		this.instanceSearch();
		this.fakeScrollbar();
		this.stickyHeader();
		this.navAjax();
		this.portfolioFilter();
		this.postAnimation();
		this.singlePost2();
		this.productVariationSwatches();
		this.productRatingTicker();
		this.productGalleryZoom();
		this.productGallerySlider();
		this.productImageSlider();
		this.productCatalog();
		this.singleProductSlider();
		this.singleProductAjaxAddToCart();
		this.openCartPanelAfterAdd();
		this.pageHeaderParallax();
		this.pageHeaderFade();
		this.responsive();
		this.pageTransition();
		this.popup();
		this.checkoutTerms();
		// this.rtlVC();
		this.wishlist();
		this.itemCarousel();

		this.loginModalAuthenticate();


		$( document.body ).trigger( 'deux_init', [deux] );
	};

	/**
	 * Check if a node is blocked for processing.
	 *
	 * @param {object} $node
	 * @return {bool} True if the DOM Element is UI Blocked, false if not.
	 */
	deux.isBlocked = function ( $node ) {
		return $node.is( '.processing' ) || $node.parents( '.processing' ).length;
	};


	/**
	 * Block a node visually for processing.
	 *
	 * @param {object} $node
	 */
	deux.block = function ( $node ) {
		if ( !deux.isBlocked( $node ) ) {
			$node.addClass( 'processing' ).block( {
				message   : null,
				overlayCSS: {
					background: '#fff',
					opacity   : 0.6
				}
			} );
		}
	};

	/**
	 * Unblock a node after processing is complete.
	 *
	 * @param {object} $node
	 */
	deux.unblock = function ( $node ) {
		$node.removeClass( 'processing' ).unblock();
	};

	/**
	 * Check if an element is in view-port or not
	 *
	 * @param el
	 * @returns {boolean}
	 */
	deux.isVisible = function ( el ) {
		if ( el instanceof jQuery ) {
			el = el[0];
		}

		var rect = el.getBoundingClientRect();

		return rect.bottom > 0 &&
			rect.right > 0 &&
			rect.left < ( window.innerWidth || document.documentElement.clientWidth ) &&
			rect.top < ( window.innerHeight || document.documentElement.clientHeight );
	};

	/**
	 * Post format gallery with carousel slider
	 */
	deux.formatGallery = function () {


		$( '.entry-gallery' ).addClass( 'owl-carousel' ).owlCarousel( {
			singleItem: true,
			items     : 1,
			navSpeed  : 800,
			nav       : true,
			dots      : false,
			autoplay  : true,
			dotsSpeed : 1000,
			rtl       : deux.data.isRTL === "1",
			navText   : ['<svg viewBox="0 0 20 20"><use xlink:href="#left-arrow"></use></svg>', '<svg viewBox="0 0 20 20"><use xlink:href="#right-arrow"></use></svg>']
		} );
	};

	/**
	 * Style checkboxes
	 */
	deux.checkBox = function () {
		// Checkbox: Ship to a different address
		$( '#ship-to-different-address' ).find( '.input-checkbox' ).on( 'change', function () {
			if ( $( this ).is( ':checked' ) ) {
				$( this ).parent().find( '.checkbox' ).addClass( 'checked' );
			} else {
				$( this ).parent().find( '.checkbox' ).removeClass( 'checked' );
			}
		} ).trigger( 'change' );
	};

	/**
	 * Load ajax on shop page and blog
	 */
	deux.navAjax = function () {
		// Blog & Portfolio
		deux.$body.on( 'click', '.ajax-navigation a:not(.ajax-load-products)', function ( e ) {
			e.preventDefault();

			var $button = $( this ),
				$nav = $button.parent(),
				$main = $( '#main' ),
				url = $button.attr( 'href' );

			if ( $nav.hasClass( 'loading' ) ) {
				return;
			}

			$nav.addClass( 'loading' );

			$.get(
				url,
				function ( response ) {
					var $response = $( response ),
						nextTitle = $response.filter( 'title' ).text();

					if ( $nav.hasClass( 'posts-navigation' ) ) {
						var $content = $( $response.find( '#main' ).html() );
						$content.hide();

						$main.append( $content );
						$content.fadeIn( 1000 );
						$nav.remove();
						deux.postAnimation();
					} else if ( $nav.hasClass( 'portfolio-navigation' ) ) {
						var $items = $response.find( '.portfolio-items .portfolio' ),
							$link = $response.find( '.ajax-navigation a' );

						if ( $items.length ) {
							$items.imagesLoaded( function () {
								$main.find( '.portfolio-items' ).isotope( 'insert', $items );
							} );
							$nav.removeClass( 'loading' );

							if ( $link.length ) {
								$nav.html( $link );
							} else {
								$nav.fadeOut();
							}
						}
					}

					window.history.pushState( null, nextTitle, url );
				}
			);
		} );

		// Shop
		if ( 'ajax' === deux.data.shop_nav_type || 'infinity' === deux.data.shop_nav_type ) {
			deux.$body.on( 'click', '.woocommerce-pagination .next', function ( e ) {
				e.preventDefault();

				var $button = $( this ),
					$nav = $button.closest( '.woocommerce-pagination' ),
					$products = $nav.prev( 'ul.products' ),
					url = $button.attr( 'href' );

				if ( $button.hasClass( 'loading' ) ) {
					return;
				}

				$button.addClass( 'loading' );

				load_products( url, $products, function ( response ) {
					var $pagination = $( response ).find( '.woocommerce-pagination' );

					if ( $pagination.length ) {
						$nav.html( $pagination.html() );
					} else {
						$nav.html( '' );
					}
				} );
			} );
		}

		// Infinity Shop
		if ( 'infinity' === deux.data.shop_nav_type ) {
			var $nav = $( '.woocommerce-pagination' ),
				$button = $nav.find( '.next' ),
				$products = $nav.prev( 'ul.products' );

			if ( $button.length ) {
				// Use this variable to control scroll event handle for better performance
				var waiting = false,
					endScrollHandle;

				deux.$window.on( 'scroll', function () {
					if ( waiting ) {
						return;
					}

					waiting = true;

					// clear previous scheduled endScrollHandle
					clearTimeout( endScrollHandle );

					infiniteScoll();

					setTimeout( function () {
						waiting = false;
					}, 100 );

					// schedule an extra execution of infiniteScoll() after 200ms
					// in case the scrolling stops in next 100ms
					endScrollHandle = setTimeout( function () {
						infiniteScoll();
					}, 200 );
				} );
			}

			var infiniteScoll = function () {
				// When almost reach to nav and new next button is exists
				if ( deux.isVisible( $nav ) && $button.length ) {
					if ( $button.hasClass( 'loading' ) ) {
						return;
					}

					$button.addClass( 'loading' );

					load_products( $button.attr( 'href' ), $products, function ( response ) {
						var $pagination = $( response ).find( '.woocommerce-pagination' );

						if ( $pagination.length ) {
							$nav.html( $pagination.html() );

							// Re-select because DOM has been changed
							$button = $nav.find( '.next' );
						} else {
							$nav.html( '' );
							$button.length = 0;
						}
					} );
				}
			}
		}

		/**
		 * Private function for ajax loading product
		 *
		 * @param url
		 * @param $holder
		 * @param callback
		 */
		function load_products( url, $holder, callback ) {
			$.get(
				url,
				function ( response ) {
					var $primary = $( response ).find( '#primary' ),
						$_products = $primary.find( 'ul.products' ).children();

					$_products.imagesLoaded( function () {

						$( '.product-images__slider', $_products ).owlCarousel( {
							items: 1,
							lazyLoad: true,
							dots: true,
							nav: false,
							rtl: deux.data.isRTL === "1",
						} );

						if ( 'function' === typeof callback ) {
							callback( response );
						}

						var index = 0;

						$_products.each( function( index ) {
							var $_product = $( this );

							setTimeout( function() {
								$holder.append($_product);
								deux.productCatalog();
								deux.productImageSlider();
							}, index * 100 );

							index++;
						} );

					} );

					window.history.pushState( null, '', url );
				}
			);
		}
	};

	/**
	 * Close topbar
	 */
	deux.closeTopbar = function () {
		$( '#topbar' ).on( 'click', '.close', function ( e ) {
			e.preventDefault();

			$( this ).closest( '#topbar' ).slideUp();
		} );
	};

	/**
	 * Main navigation sub-menu hover
	 */
	deux.menuHover = function () {
		$( '.site-navigation li, .topbar-menu li' ).on( 'mouseenter', function () {
			$( this ).addClass( 'active' ).children( '.sub-menu' ).stop( true, true )
			.velocity({ opacity: 1, top:"100%" }, {display:"block", duration: 300, easing: 'ease' } );
		} ).on( 'mouseleave', function () {
			$( this ).removeClass( 'active' ).children( '.sub-menu' ).stop( true, true )
			.velocity({ opacity: 0, top:"120%" }, {display:"none", duration: 300, easing: 'ease' }  );			
		} );
		
		
		var $mega_container = $('ul.mega-menu-container');
		
		if (deux.data.isRTL != '1') {
			if (deux.$window.width() > 1199 && $mega_container.length > 0 && !deux.$body.hasClass('header-v6') ) {            
				
				if ( $mega_container.parents('.site-navigation').length == 0 ) {return}

				var $left_pos = $mega_container.parents('.site-navigation').position().left;

				if (deux.$body.hasClass('header-v5') || deux.$body.hasClass('header-v4')) {
					var $left_pos = $mega_container.parents('.site-navigation').parent().position().left;
				}

				$mega_container.wrapInner( "<li class='mega-menu-container-inner container mega-sub-menu'><ul class='sub-menu'></ul></li>");
				if( deux.$body.hasClass('header-v3') || deux.$body.hasClass('header-v5') ) {
					$mega_container.css('transform', 'translate(-' + $left_pos + 'px , 23px)');
				} else {
					$mega_container.css('transform', 'translate(-' + $left_pos + 'px , 39px)');
				}
			}
		} else {
			if (deux.$window.width() > 1199 && $mega_container.length > 0 && !deux.$body.hasClass('header-v6') ) {            
				$mega_container.wrapInner( "<li class='mega-menu-container-inner container mega-sub-menu'><ul class='sub-menu'></ul></li>");
				var $left_pos = $mega_container.parents('.site-navigation').position().left;
				
				if (deux.$body.hasClass('header-v5') || deux.$body.hasClass('header-v4')) {
					var $left_pos = $mega_container.parents('.site-navigation').parent().position().left;
				}

				if( deux.$body.hasClass('header-v2') || deux.$body.hasClass('header-v4')) {
					$mega_container.css('transform', 'translate(' + $left_pos + 'px , 39px)');
				} else if ( deux.$body.hasClass('header-v3') || deux.$body.hasClass('header-v5') ){
					$mega_container.css('transform', 'translate(' + $left_pos + 'px , 23px)');
				}
			}
		}

	};

	/**
	 * iziModal.
	 */
	deux.iziModal = function () {
		if( $('[data-toggle="iziModal-open"]').length ){

			$('[data-toggle="iziModal-open"]').iziModal({
				radius: 4,
				zindex: 9999,
				onOpening: function(){
					$('.login-modal').addClass('modal-show');
				},
			});

			deux.$body.on( 'click touchstart', '.mobile-menu-bottom [data-izimodal-open="#login-modal"]', function () {
				$( '.side-menu' ).removeClass( 'open' );
				deux.toggleSideMenuBehavior('close');
			} );		
		}
	};

	/**
	 *  Toggle modal
	 */
	deux.toggleModal = function () {
		deux.$body.on( 'click', '[data-toggle="modal"]', function ( e ) {
			e.preventDefault();

			var $el = $( this ),
				$target = $( '#' + $el.data( 'target' ) ),
				tab = $el.data( 'tab' );

			if ( !$target.length ) {
				return;
			}

			deux.openModal( $target, tab );
			deux.toggleSideMenuBehavior('open');

		} );

		deux.$body.on( 'click', '.close-modal, .side-menu-overlay, .deux-modal-backdrop', function ( e ) {
			e.preventDefault();
			deux.toggleSideMenuBehavior('close');
			deux.closeModal();
		} );

		// Close when press escape button
		$( document ).on( 'keyup', function ( e ) {
			if ( e.keyCode === 27 ) {
				deux.toggleSideMenuBehavior('close');
				deux.closeModal();
			}
		} );
	};

	/**
	 * Open modal
	 *
	 * @param $modal
	 * @param tab
	 */
	deux.openModal = function ( $modal, tab ) {
		$modal = $modal instanceof jQuery ? $modal : $( $modal );

		if ( ! $modal.length ) {
			return;
		}

		deux.$body.addClass( 'modal-open' );
		$modal.fadeIn();
		$modal.addClass( 'open' );

		if ( tab ) {
			var $tab = $modal.find( '.tab-nav' ).filter( '[data-tab="' + tab + '"]' );

			$tab.trigger( 'click' );
		}
	};

	/**
	 * Close modal
	 */
	deux.closeModal = function () {
		deux.$body.removeClass( 'modal-open' );

		var $opened = $( '.deux-modal.open' );

		$opened.fadeOut( function () {
			$( this ).removeClass( 'open' );
		} );

		deux.$body.trigger( 'deux_modal_closed', [$opened] );
	};

	/*
	 * Remove Cart Item
	 */
	deux.removeCartItem = function () {
		var $cartModal = $( '#cart-panel' );

		$cartModal.on( 'click', '.remove', function ( e ) {
			e.preventDefault();
			$cartModal.addClass( 'loading' );
			deux.block( $cartModal );
			var currentURL = $( this ).attr( 'href' );

			$.ajax( {
				type    : 'GET',
				url     : currentURL,
				dataType: 'html',
				success : function () {
					$( document.body ).trigger( 'wc_fragment_refresh' );

					$( document.body ).on( 'wc_fragments_refreshed', function () {
						$cartModal.removeClass( 'loading' );
						deux.unblock( $cartModal );
					} );
				}
			} );
		} );
	};

	/**
	 * SlideOut Panel
	 */
	deux.toggleSlide = function () {
		deux.$body.on( 'click', '[data-toggle="slide"]', function ( e ) {
			e.preventDefault();

			var $el = $( this ),
				$target = $( '#' + $el.data( 'target' ) ),
				acc_item = $el.data( 'accordion-item' );

			if ( !$target.length ) {
				return;
			}

			deux.openSlideOut( $target, acc_item );
		} );

		deux.$body.on( 'click', '.side-menu-overlay, .close-cart-panel', function ( e ) {
			e.preventDefault();

			deux.closeSlideOut();
		} );

	};

	deux.openSlideOut = function( $slide, item ){
		$slide = $slide instanceof jQuery ? $slide : $( $slide );

		if ( ! $slide.length ) {
			return;
		}

		$slide.addClass( 'open' );
		deux.toggleSideMenuBehavior( 'open' );

		if( item ){
			deux.openAccordionCartItems( item );			
		}
	};

	deux.closeSlideOut = function(){
		$( '#cart-panel' ).removeClass( 'open' );
		deux.toggleSideMenuBehavior('close');
		deux.openAccordionCartItems('cart');
	};

	/**
	 * Open Accordion section
	 */
	deux.openAccordionCartItems = function (section) {

	    var sections = ['cart', 'wishlist'];
	    var container = '.cart-panel__content';
	    var key;

	    for (var i = 0; i < 2; i++) {
	        if (sections[i] == section) {
	            key = i;
	            break;
	        }
	    }

	    $('div[data-type=' + sections[key] + ']').appendTo(container).removeClass('inactive').addClass('active');
	    $('.accordion-item.active .accordion-tab > .tab').addClass('active');

	    for (var i = 0; i < 2; i++) {
	        if (i != key) {
	            $('div[data-type=' + sections[i] + ']').appendTo(container).removeClass('active').addClass('inactive');
	            $('.accordion-item.inactive .accordion-tab > .tab').removeClass('active');
	        }
	    }

	};

	/**
	 * Items on panel cart
	 */
	deux.accordionCartItem = function(){
		$('.accordion-item > .accordion-tab').on('click', function (e) {
	        var section = $(this).parent().attr('data-type');
	        deux.openAccordionCartItems(section);
	    });
	};

	deux.toggleSideMenuBehavior = function (nextState) {
		if( nextState == 'open' ){
			deux.$body.toggleClass( 'side-menu-opened' )
			.find('.side-menu-overlay')
			.velocity({ opacity: 1 }, { duration: 300, easing: 'ease' });
		}

		if (nextState == 'close' ) {
			$('.side-menu-overlay').velocity({ opacity: 0 }, { duration: 300, easing: 'ease' });
			setTimeout(function() {
				deux.$body.removeClass( 'side-menu-opened' );
			}, 300);
			
		}
	};

	/**
	 * Toggle side menu and its' child items
	 */
	deux.toggleSideMenu = function () {
		// Toggle side menu
		deux.$body.on( 'click', '.toggle-nav', function () {
			var target = '#' + $( this ).data( 'target' );

			$( target ).toggleClass( 'open' );
			deux.toggleSideMenuBehavior('open');
		} );

		// Close when click to backdrop
		deux.$body.on( 'click touchstart', '.side-menu-overlay', function () {
			$( '.side-menu' ).removeClass( 'open' );
			deux.toggleSideMenuBehavior('close');
		} );

		deux.$body.on( 'click touchstart', '.mobile-menu-bottom [data-target="cart-panel"]', function () {
			$( '.mobile-menu' ).removeClass( 'open' );
			deux.toggleSideMenuBehavior('open');
		} );

		// Add class 'open' to current menu item
		deux.$sideMenu.find( '.menu > .menu-item-has-children, .menu > ul > .menu-item-has-children' ).filter( function () {
			return $( this ).hasClass( 'current-menu-item' ) || $( this ).hasClass( 'current-menu-ancestor' );
		} ).addClass( 'open' );

		// Toggle sub-menu
		deux.$sideMenu.on( 'click', '.menu > .menu-item-has-children > a, .menu > ul > .menu-item-has-children > a', function ( e ) {
			e.stopPropagation();
			e.preventDefault();
			
			var isOpen = $(this).next('ul').is(':visible'),
			slideDir = isOpen ? 'slideUp' : 'slideDown',
			fadeDir = isOpen ? 'fadeOut' : 'fadeIn';

			$( this ).parent().toggleClass( 'open' ).find( 'ul' ).velocity(slideDir, { duration: 500 }).velocity(fadeDir, { duration: 700 });
			$( this ).parent().siblings( '.open' ).removeClass( 'open' ).find( 'ul' ).velocity("slideUp", { duration: 300 }).velocity('fadeOut', { duration: 300 });;
		} );
	};

	/**
	 * Focusing inputs and adds 'active' class
	 */
	deux.focusInputs = function () {
		$( '#commentform' ).on( 'focus', ':input', function () {
			$( this ).closest( 'p' ).addClass( 'active' );
		} ).on( 'focusout', ':input', function () {
			if ( $( this ).val() === '' ) {
				$( this ).closest( 'p' ).removeClass( 'active' );
			}
		} ).find( ':input' ).each( function () {
			if ( $( this ).val() !== '' ) {
				$( this ).closest( 'p' ).addClass( 'active' );
			}
		} );

	};

	/**
	 * Toggle tabs
	 */
	deux.toggleTabs = function () {
		deux.$body.on( 'click', '.tabs-nav .tab-nav', function () {
			var $tab = $( this ),
				tab = $tab.data( 'tab' );

			if ( $tab.hasClass( 'active' ) ) {
				return;
			}

			$tab.addClass( 'active' ).siblings( '.active' ).removeClass( 'active' );
			$tab.closest( '.tabs-nav' ).next( '.tab-panels' )
				.children( '[data-tab="' + tab + '"]' ).addClass( 'active' )
				.siblings( '.active' ).removeClass( 'active' );
		} )
	};

	/**
	 * Make products filterable with ajax
	 */
	deux.filterProducts = function () {	

		$( '.products-filter' ).on( 'click', 'li', function ( e ) {
			e.preventDefault();
			e.stopPropagation();

			var $this = $( this ),
				selector = $this.attr( 'data-filter' ),
				url = $this.find('a').attr( 'href' ),
				$container = $this.closest( '.shop-toolbar' ).next().next( 'ul.products' ),
				$container_height = $container.height() * 2,
				offset_toolbar = $(this).offset().top - 60;

			// set up before new product append
			$container.css('height', $container_height);
			$("html").velocity("scroll", { offset: offset_toolbar, mobileHA: false });
			if ( $this.hasClass( 'active' ) ) {
				return;
			}

			$this.addClass( 'active' ).siblings( '.active' ).removeClass( 'active' );
				
			$container.find('.product').velocity({ opacity: .3 }, { duration: 300 });

			$this.next( '.filter-loading-icon' ).velocity({ opacity: 1 }, { duration: 300,  display: 'block' });
			
			$container.next( '.woocommerce-pagination' ).remove();

			$.get(
				url,
				function ( response ) {
					var $response = $( response ),
						$content = $( $response.find( '.products' ).html() ),
						$link = $response.find( '.woocommerce-pagination' ),
						nextTitle = $response.filter( 'title' ).text();

					$this.next( '.filter-loading-icon' ).hide('0');
					

					setTimeout(function(){ $container.find('.product').remove(); }, 100);

					setTimeout(function(){
						$container.imagesLoaded( function () {
							$container.append($content);
							deux.productCatalog();
							deux.productImageSlider();
						} );
						$link.insertAfter($container);	
					}, 200);

					setTimeout(function(){ $container.css('height', 'auto');}, 500);


					window.history.pushState( null, nextTitle, url );
				}
			);

			
		} );
	};

	/**
	 * Use select2 to styling the dropdown of the ordring
	 */
	deux.sortProducts = function() {
		if ( ! $.fn.select2 ) {
			return;
		}

		$( '.woocommerce-ordering select' ).select2( {
			minimumResultsForSearch: -1,
			width: 'auto',
			dropdownAutoWidth: true
		} );
	};

	/**
	 * Change product quantity
	 */
	deux.productQuantity = function () {
		deux.$body.on( 'click', '.quantity .increase, .quantity .decrease', function ( e ) {
			e.preventDefault();

			var $this = $( this ),
				$qty = $this.siblings( '.qty' ),
				current = parseInt( $qty.val(), 10 ),
				min = parseInt( $qty.attr( 'min' ), 10 ),
				max = parseInt( $qty.attr( 'max' ), 10 );

			min = min ? min : 1;
			max = max ? max : current + 1;

			if ( $this.hasClass( 'decrease' ) && current > min ) {
				$qty.val( current - 1 );
				$qty.trigger( 'change' );
			}
			if ( $this.hasClass( 'increase' ) && current < max ) {
				$qty.val( current + 1 );
				$qty.trigger( 'change' );
			}
		} );
	};

	/**
	 * Show photoSwipe lightbox for product images
	 */
	deux.productImagesLightbox = function () {
		if ( 'no' === deux.data.lightbox || '0' === deux.data.lightbox ) {
			return;
		}

		var $gallery = $( 'div.product div.images' ),
		    $productImage = $gallery.find( '.is-image-trigger' ),
			$slides = $( '.woocommerce-product-gallery__slider .woocommerce-product-gallery__image', $gallery );

		if ( !$gallery.length ) {
			return;
		}

		$productImage.bind( 'click', function ( e ) {
			e.preventDefault();

			var items = getGalleryItems(),
				$target = $( e.target ),
				$clicked = $target.closest( '.owl-item' ),
				index = $clicked.length ? $clicked.index() : $target.closest( '.woocommerce-product-gallery__image' ).index(),
				options = {
					index              : index,
					history            : false,
					bgOpacity          : 0.85,
					showHideOpacity    : true,
					mainClass          : 'pswp--minimal-dark',
					barsSize: {
                        top: 0,
                        bottom: 0
                    },
					captionEl          : true,
					fullscreenEl       : false,
					shareEl            : false,
					tapToClose         : true,
					tapToToggleControls: false
				};

			var lightBox = new PhotoSwipe( $( '.pswp' ).get(0), window.PhotoSwipeUI_Default, items, options );
			lightBox.init();

			// Event: Before slides change
			var slide = index;
			lightBox.listen('beforeChange', function(dirVal) {
				slide = slide + dirVal;
				$slides.trigger('to.owl.carousel', [slide, 300]); 
			});
		} );

		/**
		 * Private function to get gallery items
		 * @returns {Array}
		 */
		function getGalleryItems() {
			var items = [];

			if ( $slides.length > 0 ) {
				$slides.each( function( i, el ) {
					var img = $( el ).find( 'img' ),
						large_image_src = img.attr( 'data-large_image' ),
						large_image_w   = img.attr( 'data-large_image_width' ),
						large_image_h   = img.attr( 'data-large_image_height' ),
						item            = {
							src  : large_image_src,
							w    : large_image_w,
							h    : large_image_h,
							title: img.attr( 'data-caption' ) ? img.attr( 'data-caption' ) : ''
						};
					items.push( item );
				} );
			}

			return items;
		}
	};

	/**
	 * Make product summary be sticky when use product layout 1
	 */
	deux.stickyProductSummary = function () {
		if ( $.fn.theiaStickySidebar && deux.$window.width() > 767 ) {
			$('.product-style-1 .woocommerce-product-gallery--with-images, .product-style-1 div.summary').theiaStickySidebar();
		}
	};

	/**
	 * Back to top icon
	 */
	deux.backToTop = function () {
		deux.$body.on( 'click', '#gototop', function ( e ) {
			e.preventDefault();

			$( 'html' ).velocity( 'scroll', {offset: '0', duration: 1200, mobileHA: false} );
		} );

		deux.$window.on( 'scroll', function(){
			if( deux.$window.scrollTop() > Number(450) ) {
				$('#gototop').fadeIn();
			} else {
				$('#gototop').fadeOut();
			}
		});
	};

	/**
	 * Fixed Footer
	 */
	deux.fixedFooter = function () {
		if ( !deux.$body.hasClass( 'footer-fixed' )) {
			return;
		}
		var footer = $( '.site-footer' ),
			content = $( '.content-fixed-footer' ),
			bodyHeight = deux.$window.outerHeight(),
			fixedFooterMargin = footer.outerHeight();

		if (fixedFooterMargin < bodyHeight ) {
			content.css({ 'margin-bottom': fixedFooterMargin });
		} else {
			content.css({ 'margin-bottom': 0 });
		}

	};
	/**
	 * Toggle product filter widgets
	 */
	deux.toggleProductFilter = function () {
		deux.$body.on( 'click', '.toggle-filter', function ( e ) {
			e.preventDefault();

			$( this ).next( '.filter-widgets' ).fadeIn( function () {
				$( this ).addClass( 'active' );
			} );
		} ).on( 'click', '.filter-widgets button.close', function () {
			$( this ).closest( '.filter-widgets' ).fadeOut( function () {
				$( this ).removeClass( 'active' );
			} );
		} );

	};

	/**
	 * Toggle product quick view
	 */
	deux.productQuickView = function () {
		if ( !deux.$body.hasClass( 'product-quickview-enable' ) ) {
			return;
		}

		var target = 'ul.products .quick_view_button';

		deux.$body.on( 'click', target, function ( e ) {
			if ( deux.$window.width() <= 768 ) {
				return;
			}

			e.preventDefault();

			var $a = $( this ),
				url = $a.data( 'url' ) ? $a.data( 'url' ) : $a.attr( 'href' ),
				$modal = $( '#quick-view-modal' ),
				$product = $modal.find( '.product' ),
				$button = $modal.find( '.modal-header .close-modal' ).first().clone();

			$product.hide().html( '' ).addClass( 'invisible' );
			$modal.addClass( 'loading' );
			deux.openModal( $modal );

			$.get( url, function ( response ) {
				var $html = $( response ),
					$summary = $html.find( '#content' ).find( '.product-summary' ),
					$gallery = $summary.find( '.images' ),
					$variations = $summary.find( '.variations_form' ),
					$carousel = $( '.woocommerce-product-gallery__slider', $gallery );

				// Remove unused elements
				$summary.find( '.product-toolbar' ).remove();
				$summary.find( 'h1.product_title' ).wrapInner( '<a href="' + url + '"></a>' );
				$gallery.find( '.thumbnails' ).remove();
				$product.show().html( $summary ).prepend( $button );

				// Force height for images
				$carousel.find( 'img' ).css( 'height', $product.outerHeight() );

				deux.productRatingTicker();

				if ( $carousel.children().length > 1 ) {
					$carousel.addClass( 'owl-carousel' ).owlCarousel( {
						rtl       : deux.data.isRTL === "1",
						items     : 1,
						smartSpeed: 500,
						dots      : true,
						nav       : false,
					} );
				}

				$gallery.css( 'opacity', 1 );

				$carousel.on( 'click', '.woocommerce-product-gallery__image a', function( event ) {
					event.preventDefault();
				} );

				$variations.wc_variation_form().find( '.variations select:eq(0)' ).change();

				if ( $.fn.tawcvs_variation_swatches_form ) {
					$variations.tawcvs_variation_swatches_form();
					deux.modifyVariationSwatches( $variations );
				}

				$variations.on( 'reset_image found_variation', function() {
					$carousel.trigger( 'to.owl.carousel', [0] );
				} );

				$modal.removeClass( 'loading' );
				$product.removeClass( 'invisible' );

				if ( typeof SimpleScrollbar !== 'undefined' ) {
					SimpleScrollbar.initEl( $summary.find( '.summary' ).get( 0 ) );
				}

				deux.$body.trigger( 'deux_quickview_opened', [$html, $modal, deux] );
			}, 'html' );

		} );
	};

	deux.productAttribute = function () {
		deux.$body.on('click', '.swatch-variation-image', function (e) {
			e.preventDefault();
			$(this).siblings('.swatch-variation-image').removeClass('selected');
			$(this).addClass('selected');
			var imgSrc = $(this).data('src'),
				imgSrcSet = $(this).data('src-set'),
				$mainImages = $(this).parents('li.product').find('.product-header > a, .product-header .product-images__slider a:first-child'),
				$image = $mainImages.find('img').first(),
				imgWidth = $image.first().width(),
				imgHeight = $image.first().height();

			$mainImages.addClass('image-loading');
			$mainImages.css({
				width  : imgWidth,
				height : imgHeight,
				display: 'block'
			});

			$image.attr('src', imgSrc);

			if (imgSrcSet) {
				$image.attr('srcset', imgSrcSet);
			}

			$image.load(function () {
				$mainImages.removeClass('image-loading');
				$mainImages.removeAttr('style');
			});
		});
	};

	/**
	 * Product instance search
	 */
	deux.instanceSearch = function () {
		var xhr = null,
			searchCache = {},
			$modal = $( '#search-modal' ),
			$form = $modal.find( 'form' ),
			$search = $form.find( 'input.search-field' ),
			$results = $modal.find( '.search-results' );

		$modal.on( 'keyup', '.search-field', function ( e ) {
			var valid = false;

			if ( typeof e.which === 'undefined' ) {
				valid = true;
			} else if ( typeof e.which === 'number' && e.which > 0 ) {
				valid = !e.ctrlKey && !e.metaKey && !e.altKey;
			}

			if ( !valid ) {
				return;
			}

			if ( xhr ) {
				xhr.abort();
			}

			search();
		} ).on( 'click', '.search-reset', function (e) {
			e.preventDefault();
			if ( xhr ) {
				xhr.abort();
			}

			$results.find( '.woocommerce, .buttons' ).fadeOut( function () {
				$modal.removeClass( 'searching searched found-products found-no-product invalid-length' );
			} );
		} ).on( 'focusout', '.search-field', function () {
			if ( $search.val().length < 2 ) {
				$results.find( '.woocommerce, .buttons' ).fadeOut( function () {
					$modal.removeClass( 'searching searched found-products found-no-product invalid-length' );
				} );
			}
		} );

		/**
		 * Private function for search
		 */
		function search() {
			var keyword = $search.val();

			if ( keyword.length < 2 ) {
				$modal.removeClass( 'searching found-products found-no-product' ).addClass( 'invalid-length' );
				return;
			}

			var url = $form.attr( 'action' ) + '?' + $form.serialize();

			$modal.removeClass( 'found-products found-no-product' ).addClass( 'searching' );

			if ( keyword in searchCache ) {
				var result = searchCache[keyword];

				$modal.removeClass( 'searching' );

				if ( result.found ) {
					$modal.addClass( 'found-products' );

					$results.find( '.woocommerce' ).html( result.products );
					$results.find( '.buttons a' ).attr( 'href', url );

					var $resultNumber = $results.find( '.woocommerce .type-product' ).length, 
						$resultText = $('.search-fields .search-field').val();
						
					$results.find( '.buttons .search-results-text span:first-child' ).text($resultNumber);
					$results.find( '.buttons .search-results-text span:last-child' ).text($resultText);
					$results.find( '.woocommerce, .buttons' ).fadeIn( function () {
						$modal.removeClass( 'invalid-length' );
					} );
				} else {
					$modal.addClass( 'found-no-product' );

					$results.find( '.woocommerce' ).html( $( '<div class="not-found" />' ).text( result.text ) );
					$results.find( '.buttons a' ).attr( 'href', '#' );

					$results.find( '.buttons' ).fadeOut();
					$results.find( '.woocommerce' ).fadeIn( function () {
						$modal.removeClass( 'invalid-length' );
					} );
				}

				$modal.addClass( 'searched' );
			} else {
				xhr = $.get( url, function ( response ) {
					var $html = $( response ),
						$products = $html.find( '#content #primary ul.products' ),
						$info = $html.find( '#content #primary .woocommerce-info' );

					$modal.removeClass( 'searching' );

					if ( $products.length ) {
						$products.children( '.last' ).nextAll().remove();

						$modal.addClass( 'found-products' );

						$results.find( '.woocommerce' ).html( $products );
						$results.find( '.buttons a' ).attr( 'href', url );

						var $resultNumber = $results.find( '.woocommerce .type-product' ).length, 
							$resultText = $('.search-fields .search-field').val();
						
						$results.find( '.buttons .search-results-text span:first-child' ).text($resultNumber);
						$results.find( '.buttons .search-results-text span:last-child' ).text($resultText);

						$results.find( '.woocommerce, .buttons' ).fadeIn( function () {
							$modal.removeClass( 'invalid-length' );
						} );

						// Cache
						searchCache[keyword] = {
							found   : true,
							products: $products
						};
					} else if ( $info.length ) {
						$modal.addClass( 'found-no-product' );

						$results.find( '.woocommerce' ).html( $( '<div class="not-found" />' ).text( $info.text() ) );
						$results.find( '.buttons a' ).attr( 'href', '#' );

						$results.find( '.buttons' ).fadeOut();
						$results.find( '.woocommerce' ).fadeIn( function () {
							$modal.removeClass( 'invalid-length' );
						} );

						// Cache
						searchCache[keyword] = {
							found: false,
							text : $info.text()
						};
					}

					$modal.addClass( 'searched' );
				}, 'html' );
			}
		}
	};

	/**
	 * Init simple scrollbar
	 */
	deux.fakeScrollbar = function () {
		var el = document.querySelector( '.primary-menu.side-menu' ),
		    elThumb = document.querySelector( '.woocommerce.product-style-2 div.product div.images div.thumbnails' );

		if ( el && typeof SimpleScrollbar !== 'undefined' ) {
			SimpleScrollbar.initEl( el );
		}

		if ( elThumb && typeof SimpleScrollbar !== 'undefined' ) {
			SimpleScrollbar.initEl( elThumb );
		}

	};

	/**
	 * Sticky header
	 */
	deux.stickyHeader = function () {
		if ( !deux.data.sticky_header || 'none' === deux.data.sticky_header ) {
			return;
		}

		var header = document.getElementById( 'masthead' );
		var topbar = document.getElementById( 'topbar' );
		var offset = 0;

		var toogle_branding = true,
		header_3_5 = (deux.$body.hasClass('header-v3') || deux.$body.hasClass('header-v5')),
		widndow_width = deux.$window.width() > 1199;

		// Prepare for white header
		if (
			deux.$body.hasClass( 'header-white' )
			|| ( deux.$body.hasClass( 'no-page-header' ) && !deux.$body.hasClass( 'page-title-hidden' ) && !deux.$body.hasClass( 'page-template-fullwidth' ) )
		) {
			if ( topbar ) {
				topbar.style.marginBottom = header.clientHeight + 'px';
			} else {
				document.getElementById( 'page' ).style.paddingTop = header.clientHeight + 'px';
			}
		}

		if ( 'smart' === deux.data.sticky_header && typeof Headroom !== 'undefined' ) {
			offset = topbar ? topbar.clientHeight : 1;

			var stickyHeader = new Headroom( header, {
				offset  : offset,
				onTop   : function () {
					setTimeout( function () {
						header.classList.remove( 'headroom--animation' );
					}, 500 );
					if (widndow_width && header_3_5) {
						$('.site-branding').velocity("slideDown", { duration: 300 });
					}
				},
				onNotTop: function () {
					setTimeout( function () {
						header.classList.add( 'headroom--animation' );
					}, 10 );
					if (widndow_width && header_3_5) {
						$('.site-branding').velocity("slideUp", { duration: 300 });
					}
				}
			} );

			stickyHeader.init();
		} else if ( 'normal' === deux.data.sticky_header ) {
			offset = topbar ? topbar.clientHeight : 1;
			sticky();
			

			deux.$window.on( 'scroll', function () {
				sticky();
			} );
		}

		/**
		 * Private function for sticky header
		 */
		function sticky() {
			if ( deux.$window.scrollTop() >= offset ) {
				header.classList.add( 'sticky' );
				if (toogle_branding && widndow_width && header_3_5) {
					$('.site-branding').velocity("slideUp", { duration: 300 });
					toogle_branding = false;
				}
			} else {
				header.classList.remove( 'sticky' );
				if (toogle_branding == false && widndow_width && header_3_5) {
					$('.site-branding').velocity("slideDown", { duration: 300 });
					toogle_branding = true;
				}

			}
		}
	};

	/**
	 * Initialize isotope for portfolio items
	 */
	deux.portfolioFilter = function () {
		var $items = $( '.portfolio-items' );

		if ( !$items.length ) {
			return;
		}

		var options = {
			itemSelector      : '.portfolio',
			transitionDuration: 700,
			isOriginLeft      : !(deux.data.isRTL === '1')
		};


		if ( deux.$body.hasClass( 'portfolio-fullwidth' ) ) {
			options.masonry = {
				columnWidth: '.col-md-3'
			};
		} else {
			options.layoutMode = 'fitRows';
		}

		$items.imagesLoaded( function () {
			$( this.elements ).isotope( options );
		} );

		var $filter = $( '.portfolio-filter' );

		$filter.on( 'click', 'li', function ( e ) {
			e.preventDefault();

			var $this = $( this ),
				selector = $this.attr( 'data-filter' );

			if ( $this.hasClass( 'active' ) ) {
				return;
			}

			$this.addClass( 'active' ).siblings( '.active' ).removeClass( 'active' );
			$this.closest( '.portfolio-filter' ).next( '.portfolio-items' ).isotope( {
				filter: selector
			} );
		} );
	};

	/**
	 * Display post animation
	 */
	deux.postAnimation = function() {
		
		var $container = $( '.blog-grid .site-main' ),
			$nth_child = ($('body').hasClass('sidebar-no-sidebar')) ? 'n+3' : 'n+2';

		$container.imagesLoaded( function () {
		 	AOS.init({
		 		duration: 1000,
		 		disable: "mobile"
		 	});
		} );
	 	$container.find('.type-post:nth-child('+$nth_child+')').each(function(index){
		    var delayNumber = ($('body').hasClass('sidebar-no-sidebar')) ? (index % 3) * 200 : (index % 2) * 200;
		    
		    $(this).attr('data-aos-delay', delayNumber);

		});

		deux.$window.on( 'load', function() {
			 AOS.refresh();
		} );
	};


	/**
	 * Add extra script for product single post 2 
	 */
	deux.singlePost2 = function(){
		if ( ! deux.$body.hasClass( 'single-layout-2' ) ) {
			return;
		}

		var background = $('.single-layout-2 .background-image');

		function stopScrolling (e) {
		    e.preventDefault();
		    e.stopPropagation();
		    return false;
		}

		function mouseWheelMove(){
			deux.$body.bind('mousewheel', function(e){
				if(!(e.originalEvent.wheelDelta /120 > 0)) {
					setTimeout( function() {
						deux.$body.off('scroll mousewheel touchmove', stopScrolling);
					}, 500 );
					background.parent().addClass('push-effect');
				}
			});
		}

		$(window).on('scroll', function () {
			var scrll = $(document).scrollTop();
			if (scrll > 0) {
				background.parent().addClass('push-effect');
				deux.$body.off('scroll mousewheel touchmove', stopScrolling);
			} else{
					background.parent().removeClass('push-effect');
					deux.$body.on('scroll mousewheel touchmove', stopScrolling);
			}
		});

		deux.$body.on('scroll mousewheel touchmove', stopScrolling);
		mouseWheelMove();
	};


	/**
	 * Add extra script for product variation swatches
	 * This function will run after plugin swatches did
	 */
	deux.productVariationSwatches = function () {
		deux.$body.on( 'tawcvs_initialized', function () {
			var $form = $( '.variations_form' );

			deux.modifyVariationSwatches( $form );
		} );
	};
	
	/**
	 * Rating Ticker
	 */
	deux.productRatingTicker = function(){
		var $ticker = $('.rating-ticker');
		if( $ticker.length > 0 ) {
			$ticker.easyTicker({
				direction: 'up',
				easing: 'swing',
				speed: 'slow',
				interval: 5000,
				height: 'auto',
				visible: 1,
				mousePause: 1,
			});			
		}
	};

	/**
	 * Modify variation swatches
	 * This function is used in deux.productVariationSwatches and deux.productQuickView
	 *
	 * @param $form
	 */
	deux.modifyVariationSwatches = function ( $form ) {
		var $variables = $form.find( '.variations .variable' );

		// Remove class "swatches-support" if there is no swatches in this product
		var hasSwatches = false;
		$variables.each( function() {
			if ( $( this ).hasClass( 'swatches' ) ) {
				hasSwatches = true;
			}
		} );

		if ( ! hasSwatches ) {
			$form.removeClass( 'swatches-support' );
		}

		// Add class for the last even variation
		if ( $variables.length % 2 ) {
			$variables.last().addClass( 'wide-variable' );
		}

		// Change alert style
		$form.off( 'tawcvs_no_matching_variations' );
		$form.on( 'tawcvs_no_matching_variations', function () {
			event.preventDefault();

			$form.find( '.woocommerce-variation.single_variation' ).show();
			if ( typeof wc_add_to_cart_variation_params !== 'undefined' ) {
				$form.find( '.single_variation' ).stop( true, true ).slideDown( 500 ).html( '<p class="invalid-variation-combination">' + wc_add_to_cart_variation_params.i18n_no_matching_variations_text + '</p>' );
			}
		} );
	};

	/**
	 * Init the zoom function for product gallery
	 */
	deux.productGalleryZoom = function() {
		deux.initZoom( '.woocommerce-product-gallery__slider .woocommerce-product-gallery__image' );

		$( '.woocommerce-product-gallery--with-images' ).on( 'woocommerce_gallery_init_zoom', function() {
			var $target = $( '.woocommerce-product-gallery__image', this ).first().trigger( 'zoom.destroy' );
			deux.initZoom( $target );
		} )
	};

	/**
	 * Init zoom function on selected image
	 *
	 * @param zoomTarget
	 */
	deux.initZoom = function( zoomTarget ) {
		if ( ! deux.data.zoom ) {
			return;
		}

		var $zoomTarget = $( zoomTarget ),
			galleryWidth = $zoomTarget.width(),
			zoomEnabled  = false;

		$zoomTarget.each( function( index, target ) {
			var image = $( target ).find( 'img' );

			if ( image.data( 'large_image_width' ) > galleryWidth ) {
				zoomEnabled = true;
				return false;
			}
		} );

		// But only zoom if the img is larger than its container.
		if ( zoomEnabled ) {
			var zoom_options = {
				touch: false
			};

			if ( 'ontouchstart' in window ) {
				zoom_options.on = 'click';
			}

			$zoomTarget.trigger( 'zoom.destroy' );
			$zoomTarget.zoom( zoom_options );
		}
	};

	/**
	 * Init product gallery as a slider
	 */
	deux.productGallerySlider = function() {
		var $gallery = $( 'div.product div.images' ),
			$carousel = $( '.woocommerce-product-gallery__slider', $gallery ),
			$thumbnails = $( '.thumbnails', $gallery );

		if ( !deux.$body.hasClass( 'product-style-1' ) && $carousel.children().length > 1 && !$carousel.hasClass( 'owl-loaded' ) ) {
			$carousel.addClass( 'owl-carousel' ).owlCarousel( {
				rtl       : deux.data.isRTL === "1",
				dots      : false,
				autoHeight:true,
				items     : 1,
				loop      : false,
				responsive: {
					0: {
						items: 1
					}
				}
			} );
		}

		if ( deux.$body.hasClass( 'product-style-1' ) && $carousel.children().length > 1 ) {
			if ( deux.$window.width() < 992 && ! $carousel.hasClass( 'owl-carousel' ) ) {
				$carousel.addClass( 'owl-carousel' ).owlCarousel( {
					rtl       : deux.data.isRTL === "1",
					items     : 1,
					loop      : false,
					margin    : 10,
					responsive: {
						0: {
							items: 1
						}
					}
				} );
			} else if ( deux.$window.width() >= 992 && $carousel.hasClass( 'owl-carousel' ) ) {
				$carousel.trigger( 'destroy.owl.carousel' ).removeClass( 'owl-carousel' );
			}
		}

		// Show it
		$gallery.css( 'opacity', 1 );

		// Use thumbnails as pagination
		$gallery.on( 'click', '.thumbnails .woocommerce-product-gallery__image a', function( event ) {
			event.preventDefault();

			var $image = $( this ).closest( '.woocommerce-product-gallery__image' );

			$carousel.trigger( 'to.owl.carousel', [$image.index()] );
		} );

		// Change the active state of thumbnails
		$carousel.on( 'translated.owl.carousel', function( event ) {
			$thumbnails.children().removeClass( 'active' ).eq( event.item.index ).addClass( 'active' );
		} );

		// Variation form changed
		$( '.variations_form' ).on( 'reset_image found_variation', function() {
			$carousel.trigger( 'to.owl.carousel', [0] );
		} ).on( 'reset_image', function() {
			$thumbnails.children( ':eq(0)' ).find( 'img' ).wc_reset_variation_attr( 'src' );
		} ).on( 'found_variation', function( event, variation ) {
			$thumbnails.children( ':eq(0)' ).find( 'img' ).wc_set_variation_attr( 'src', variation.image.thumb_src );
		} );
	};

	/**
	 * Display product thumbnail images as slider
	 */
	deux.productImageSlider = function() {
		var product_image_container = !($( '.product-images__slider' ).parents('.deux-product-carousel, .related').length);
		
		$( '.product-images__slider' ).owlCarousel( {
			items: 1,
			lazyLoad: true,
			dots: true,
			nav: false,
			rtl: deux.data.isRTL === "1",
			mouseDrag: product_image_container
		} );

		$( '.deux-product-carousel' ).on( 'initialized.owl.carousel', function() {
			$( '.product-images__slider' ).trigger( 'refresh.owl.carousel' );
		} );
	};

	/**
	 * Display product animation
	 */
	deux.productCatalog = function() {
		
		var $container = $( '.woocommerce.archive .site-content ul.products, .deux-product-grid ul.products' );

		$( '.deux-product-carousel li.product > .aos-item' ).attr('data-aos', ' ');

		$container.imagesLoaded( function () {
		 	AOS.init({
		 		duration: 1000,
		 		disable: "mobile"
		 	});
		} );

	 	$container.each(function(index){
		 	$(this).find('.product').each(function(index){
			    var $this = $(this),
			    	$container = $this.parents('ul.products'),
			    	grid = Math.floor($container.width() / $this.width()),
			    	delayNumber = (index % grid) * 200;
			    	$this.find('.aos-item').attr('data-aos-delay', delayNumber);
			});
		});

		deux.$window.on( 'load', function() {
			 AOS.refresh();
		} );
	};

	deux.singleProductSlider = function() {
		if (!deux.$body.hasClass('single-product')) {
			return;
		}
		var $upsells = deux.$body.find('.up-sells ul.products'),
			$related = deux.$body.find('.related.products ul.products');

		$upsells.addClass( 'owl-carousel' ).owlCarousel( {
			rtl   : deux.data.isRTL === "1",
			items: parseInt(deuxData.upsells_products_columns),			
			lazyLoad: true,
			dots: true,
			nav: false,
			responsive:{
		        0:{
		            items:1
		        },
		        480:{
		            items:2
		        },
		        767:{
		            items:3
		        },
		        1200:{
		            items: parseInt(deuxData.related_products_columns)
		        },
		    },
			onInitialized: function() {
		    	$('li.product').css( 'width', $upsells.find('.owl-item').width() );
		    },
		    onResized: function() {
		    	$('li.product').css( 'width', $upsells.find('.owl-item').width() );
		    }
		} );

		$related.addClass( 'owl-carousel' ).owlCarousel( {
			rtl   : deux.data.isRTL === "1",
			items: parseInt(deuxData.related_products_columns),
			lazyLoad: true,
			dots: true,
			nav: false,
			responsive:{
		        0:{
		            items:1
		        },
		        480:{
		            items:2
		        },
		        767:{
		            items:3
		        },
		        1200:{
		            items: parseInt(deuxData.related_products_columns)
		        },
		    },
		    onInitialized: function() {
		    	$('li.product').css( 'width', $related.find('.owl-item').width() );
		    },
		    onResized: function() {
		    	$('li.product').css( 'width', $related.find('.owl-item').width() );
		    }
		} );	

	};

	/**
	 * Ajaxify add to cart button on single product page
	 */
	deux.singleProductAjaxAddToCart = function () {
		if ( 'yes' !== deux.data.single_ajax_add_to_cart ) {
			return;
		}

		deux.$body.on( 'submit', 'form.cart', function () {
			var $form = $( this ),
				$button = $form.find( '.single_add_to_cart_button' ),
				$action_loader = $('.woocommerce #cart-action-loader'),
				url = $form.attr( 'action' ) ? $form.attr( 'action' ) : window.location.href;

			if ( $button.hasClass( 'loading' ) ) {
				return false;
			}

			deux.LoaderAjaxAddToCart( 'before', $action_loader );						
			$button.removeClass( 'added' ).addClass( 'loading' );	

			$.ajax( {
				url    : url,
				data   : $form.serialize(),
				method : 'POST',
				success: function ( response ) {
					$button.removeClass( 'loading' ).addClass( 'added' );
					deux.LoaderAjaxAddToCart( 'after', $action_loader );	

					// Show alert bar
					if ( deux.data.open_cart_modal_after_add !== '1' ) {
						var $message = $( response ).find( '.woocommerce-error, .woocommerce-info, .woocommerce-message' ),
							$alert = $( '.alert-modal' );

						if ( !$alert.length ) {
							$alert = $( '<div class="alert-modal"></div>' );
							deux.$body.append( $alert );
						}

						$alert.html( $message );
						setTimeout( function () {
							$alert.addClass( 'active' );
						}, 500 );

						// Auto hide the alert bar after 5 seconds. Apply for success actions only
						if ( $message.hasClass( 'woocommerce-message' ) ) {
							setTimeout( function () {
								$alert.removeClass( 'active' );
							}, 5000 );
						}
					} else {
						deux.$body.trigger( 'added_to_cart' );
					}

					// Trigger fragment refresh
					deux.$body.trigger( 'wc_fragment_refresh' );

					if ( typeof wc_add_to_cart_params !== 'undefined' ) {
						if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' && wc_add_to_cart_params.cart_url ) {
							window.location.href = wc_add_to_cart_params.cart_url;
						}
					}
				}
			} );

			return false;
		} );

		// Close alert bar
		deux.$body.on( 'click', '.alert-modal .close', function ( e ) {
			e.preventDefault();

			$( this ).closest( '.alert-modal' ).removeClass( 'active' );
		} );
	};

	deux.LoaderAjaxAddToCart = function( state, action ){
		if( state == 'before' ){
			$('form.cart').velocity({ opacity: 0 }, { duration: 500, easing: 'easeInOutCubic' });
			action.velocity({ opacity: 1 }, { duration: 500, easing: 'easeInOutCubic', display: 'block' });
			action.find('.added').css( 'display', 'none' );
			action.find('.adding').css( 'display', 'block' );
		}

		if( state == 'after' ){
			action.find('.adding').css( 'display', 'none' );						
			action.find('.added').css( 'display', 'block' );						
			action.velocity({ opacity: 0 }, { delay: 1500, duration: 500, easing: 'easeInOutCubic', display: 'none' });
	        $('form.cart').velocity({ opacity: 1 }, { delay: 1500, duration: 500, easing: 'easeInOutCubic' });
		}
	};

	/**
	 * Open the cart modal after successful addition
	 */
	deux.openCartPanelAfterAdd = function () {
		if ( deux.data.open_cart_modal_after_add !== '1' ) {
			return;
		}

		deux.$body.on( 'added_to_cart', function () {
			
			deux.toggleSideMenuBehavior('open');
			$('#cart-panel').addClass('open');
		} );			

	};

	/**
	 * Init parallax for page header elements
	 */
	deux.pageHeaderParallax = function () {
		if ( typeof Rellax === 'undefined' ) {
			return;
		}

		var $title = $( '.page-header .page-title' ),
			$breadcrumb = $( '.page-header .breadcrumb' ),
			$pageHeaderImage = $( '.page-header-image .page-header .page-header-image' );

		if ( 'up' === deux.data.page_header_parallax ) {
			if ( $title.length ) {
				new Rellax( '.page-header .page-title', {speed: 1} );
			}
			if ( $breadcrumb.length ) {
				new Rellax( '.page-header .breadcrumb', {speed: 2} );
			}
			if ( $pageHeaderImage.length ) {
				new Rellax( '.page-header-image .page-header .page-header-image', {speed: -1} );
			}
		} else if ( 'down' === deux.data.page_header_parallax ) {
			if ( $title.length ) {
				new Rellax( '.page-header .page-title', {speed: -1.5} );
			}
			if ( $breadcrumb.length ) {
				new Rellax( '.page-header .breadcrumb', {speed: -1} );
			}
			if ( $pageHeaderImage.length ) {
				new Rellax( '.page-header-image .page-header .page-header-image', {speed: -1} );
			}
		}
	};

	deux.pageHeaderFade = function () {
		var $header = $( '.page-header-image .page-header' );

		$(window).on('scroll', function () {
			var scrll = $(document).scrollTop(),
				opacityVal = (600 - scrll) / 600,
				translateVal = scrll / 10;
				$header.css('opacity', opacityVal);
		});
	};

	/**
	 * Add page Transition
	 */
	deux.pageTransition = function(){
		if( deux.$body.hasClass('no-transition') ) { return true; }

		window.onpageshow = function(event) {
			if(event.persisted) {
				window.location.reload();
			}
		};

			var animationIn = deux.$body.attr('data-animation-in'),
				animationOut = deux.$body.attr('data-animation-out'),
				durationIn = deux.$body.attr('data-speed-in'),
				durationOut = deux.$body.attr('data-speed-out'),
				loaderTimeOut = deux.$body.attr('data-loader-timeout'),
				loaderStyle = deux.$body.attr('data-loader'),
				loaderColor = deux.$body.attr('data-loader-color'),
				loaderStyleHtml = '<div class="css3-spinner-bounce1"></div><div class="css3-spinner-bounce2"></div><div class="css3-spinner-bounce3"></div>',
				loaderBgStyle = '',
				loaderBorderStyle = '',
				loaderBgClass = '',
				loaderBorderClass = '',
				loaderBgClass2 = '',
				loaderBorderClass2 = '';

			if( !animationIn ) { animationIn = 'fade-in'; }
			if( !animationOut ) { animationOut = 'fade-out'; }
			if( !durationIn ) { durationIn = 1500; }
			if( !durationOut ) { durationOut = 800; }
			
			if( !loaderTimeOut ) {
				loaderTimeOut = false;
			} else {
				loaderTimeOut = Number(loaderTimeOut);
			}

			if( loaderColor ) {
				if( loaderColor == 'theme' ) {
					loaderBgClass = ' bgcolor';
					loaderBorderClass = ' border-color';
					loaderBgClass2 = ' class="bgcolor"';
					loaderBorderClass2 = ' class="border-color"';
				} else {
					loaderBgStyle = ' style="background-color:'+ loaderColor +';"';
					loaderBorderStyle = ' style="border-color:'+ loaderColor +';"';
				}
				loaderStyleHtml = '<div class="css3-spinner-bounce1'+ loaderBgClass +'"'+ loaderBgStyle +'></div><div class="css3-spinner-bounce2'+ loaderBgClass +'"'+ loaderBgStyle +'></div><div class="css3-spinner-bounce3'+ loaderBgClass +'"'+ loaderBgStyle +'></div>'
			}

			if( loaderStyle == '2' ) {
				loaderStyleHtml = '<div class="css3-spinner-flipper'+ loaderBgClass +'"'+ loaderBgStyle +'></div>';
			} else if( loaderStyle == '3' ) {
				loaderStyleHtml = '<div class="css3-spinner-double-bounce1'+ loaderBgClass +'"'+ loaderBgStyle +'></div><div class="css3-spinner-double-bounce2'+ loaderBgClass +'"'+ loaderBgStyle +'></div>';
			} else if( loaderStyle == '4' ) {
				loaderStyleHtml = '<div class="css3-spinner-rect1'+ loaderBgClass +'"'+ loaderBgStyle +'></div><div class="css3-spinner-rect2'+ loaderBgClass +'"'+ loaderBgStyle +'></div><div class="css3-spinner-rect3'+ loaderBgClass +'"'+ loaderBgStyle +'></div><div class="css3-spinner-rect4'+ loaderBgClass +'"'+ loaderBgStyle +'></div><div class="css3-spinner-rect5'+ loaderBgClass +'"'+ loaderBgStyle +'></div>';
			} else if( loaderStyle == '5' ) {
				loaderStyleHtml = '<div class="css3-spinner-cube1'+ loaderBgClass +'"'+ loaderBgStyle +'></div><div class="css3-spinner-cube2'+ loaderBgClass +'"'+ loaderBgStyle +'></div>';
			} else if( loaderStyle == '6' ) {
				loaderStyleHtml = '<div class="css3-spinner-scaler'+ loaderBgClass +'"'+ loaderBgStyle +'></div>';
			} else if( loaderStyle == '7' ) {
				loaderStyleHtml = '<div class="css3-spinner-grid-pulse"><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div></div>';
			} else if( loaderStyle == '8' ) {
				loaderStyleHtml = '<div class="css3-spinner-clip-rotate"><div'+ loaderBorderClass2 + loaderBorderStyle +'></div></div>';
			} else if( loaderStyle == '9' ) {
				loaderStyleHtml = '<div class="css3-spinner-ball-rotate"><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div></div>';
			} else if( loaderStyle == '10' ) {
				loaderStyleHtml = '<div class="css3-spinner-zig-zag"><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div></div>';
			} else if( loaderStyle == '11' ) {
				loaderStyleHtml = '<div class="css3-spinner-triangle-path"><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div></div>';
			} else if( loaderStyle == '12' ) {
				loaderStyleHtml = '<div class="css3-spinner-ball-scale-multiple"><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div></div>';
			} else if( loaderStyle == '13' ) {
				loaderStyleHtml = '<div class="css3-spinner-ball-pulse-sync"><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div><div'+ loaderBgClass2 + loaderBgStyle +'></div></div>';
			} else if( loaderStyle == '14' ) {
				loaderStyleHtml = '<div class="css3-spinner-scale-ripple"><div'+ loaderBorderClass2 + loaderBorderStyle +'></div><div'+ loaderBorderClass2 + loaderBorderStyle +'></div><div'+ loaderBorderClass2 + loaderBorderStyle +'></div></div>';
			}

			$('#page').animsition({
				inClass : animationIn,
				outClass : animationOut,
				inDuration : Number(durationIn),
				outDuration : Number(durationOut),
				linkElement : '#site-navigation ul li a:not([target="_blank"]):not([href*=\\#]):not([data-lightbox])',
				loading : true,
				loadingParentElement : 'body',
				loadingClass : 'css3-spinner',
				loadingInner : loaderStyleHtml,
				browser : [
								 'animation-duration',
								 '-webkit-animation-duration',
								 '-o-animation-duration'
							   ],
				overlay : false,
				overlayClass : 'animsition-overlay-slide',
				overlayParentElement : 'body',
				timeOut: loaderTimeOut
			});
	};

	/**
	 * Call functions for responsiveness
	 */
	deux.responsive = function () {
		// Initialize fitvids
		deux.responsiveVideos();

		deux.$window.on('resize', function(e) {
			e.preventDefault();
			
			// Init/destroy product image carousel for product style 1
			deux.productGallerySlider();
			
			// init aos 
			deux.productCatalog();

		});

	};

	/**
	 * Responsive videos
	 */
	deux.responsiveVideos = function () {
		$( document.body ).fitVids();
	};

	/**
	 * Open popup
	 */
	deux.popup = function() {
		var days = parseInt( deux.data.popup_frequency ),
			delay = parseInt( deux.data.popup_visible_delay );

		if ( days > 0 && document.cookie.match( /^(.*;)?\s*deux_popup\s*=\s*[^;]+(.*)?$/ ) ) {
			return;
		}

		delay = Math.max( delay, 0 );
		delay = 'delay' === deux.data.popup_visible ? delay : 0;

		deux.$window.on( 'load', function() {
			setTimeout( function() {
				deux.openModal( '#popup' );
			}, delay * 1000 );
		} );

		deux.$body.on( 'deux_modal_closed', function (event, modal) {
			if ( ! modal.hasClass( 'deux-popup' ) ) {
				return;
			}

			var date = new Date(),
				value = date.getTime();

			date.setTime( date.getTime() + (days * 24 * 60 * 60 * 1000) );

			document.cookie = 'deux_popup=' + value + ';expires=' + date.toGMTString() + ';path=/';
		} );
	};

	/**
	 * Turn off the event handler for terms and conditions link
	 */
	deux.checkoutTerms = function() {
		deux.$body.off( 'click', 'a.woocommerce-terms-and-conditions-link' );
	};

	/**
	 * Row full width in RTL
	 */
	// deux.rtlVC = function() {
	// 	if ( deux.data.isRTL !== '1' ) {
	// 		return;
	// 	}
	// 	$( document ).on( 'vc-full-width-row-single', function( event, data ) {
	// 		data.el.css( {
	// 			left: 'auto',
	// 			right: data.offset
	// 		} );
	// 	} );
	// };

	/**
	 * Wishlist fragments
	 */
	 
	deux.wishlist = function() {

		setTimeout(function() {
            deux.$body.addClass('wishlist-show');
        }, 1000);

		$('.yith-wcwl-add-button.show').each( function(){
            var wishListText = $(this).find('a').text();
            $(this).find('a').attr( 'data-hover', wishListText );
        });

		 /* Storage Handling */
        var $supports_html5_storage;
        try {
            $supports_html5_storage = ( 'sessionStorage' in window && window.sessionStorage !== null );
            window.sessionStorage.setItem( 'deux', 'test' );
            window.sessionStorage.removeItem( 'deux' );
        } catch( err ) {
            $supports_html5_storage = false;
        }

        /* Cart session creation time to base expiration on */
        function set_wishlist_creation_timestamp() {
            if ( $supports_html5_storage ) {
                sessionStorage.setItem( 'deux_wishlist_created', ( new Date() ).getTime() );
            }
        }

        /** Set the cart hash in both session and local storage */
        function set_wishlist_hash( hash ) {
            if ( $supports_html5_storage ) {
                localStorage.setItem( 'deux_wishlist_hash', hash );
                sessionStorage.setItem( 'deux_wishlist_hash', hash );
            }
        }

        var $fragment_refresh = {
            url: deux.data.ajax_url,
            data: {
                action: 'deux_add_to_wishlist_fragments'
            },
            method: 'GET',
            success: function(data) {
            	if ( data && data.wishlist ) {
                
                $.each( data.wishlist, function ( element, content ) {
					$( element ).replaceWith( content );
				} );

                if ( $supports_html5_storage ) {
                    sessionStorage.setItem( 'deux_wishlist', JSON.stringify( data.wishlist ) );

                    set_wishlist_hash( data.wishlist_hash );

                    if ( data.wishlist_hash ) {
                        set_wishlist_creation_timestamp();
                    }
                }
            	}
            }
        };

        function refresh_wishlist_fragment() {
            $.ajax( $fragment_refresh );
        }

        /* Cart Handling */
        if ( $supports_html5_storage ) {

            var wishlist_timeout = null,
                day_in_ms    = ( 24 * 60 * 60 * 1000 );

            $( document.body ).bind( 'added_to_cart added_to_wishlist removed_from_wishlist', function() {
                var prev_wishlist_hash = sessionStorage.getItem( 'deux_wishlist_hash' );

                if ( prev_wishlist_hash === null || prev_wishlist_hash === undefined || prev_wishlist_hash === '' ) {
                    set_wishlist_creation_timestamp();
                }

                refresh_wishlist_fragment();

            });

            try {
                var wishlist_fragment = sessionStorage.getItem( 'deux_wishlist' ),
                    wishlist_hash    = sessionStorage.getItem( 'deux_wishlist_hash' ),
                    cookie_hash  = $.cookie( 'deux_wishlist_hash'),
                    wishlist_created = sessionStorage.getItem( 'deux_wishlist_created' );

                if ( wishlist_hash === null || wishlist_hash === undefined || wishlist_hash === '' ) {
                    wishlist_hash = '';
                }

                if ( cookie_hash === null || cookie_hash === undefined || cookie_hash === '' ) {
                    cookie_hash = '';
                }

                if ( wishlist_hash && ( wishlist_created === null || wishlist_created === undefined || wishlist_created === '' ) ) {
                    throw 'No wishlist_created';
                }

                if ( wishlist_fragment && wishlist_hash === cookie_hash ) {
                   
	                $.each( wishlist_fragment, function ( element, content ) {
						$( element ).replaceWith( content );
					} );

                } else {
                    throw 'No fragment';
                }

            } catch( err ) {
                refresh_wishlist_fragment();
            }

        } else {
            refresh_wishlist_fragment();
        }

	};
	/**
	 * Product carousel
	 */

	deux.itemCarousel = function(){
		$( '.deux-carousel' ).each( function () {
		var $carousel = $( this ),
			columns = parseInt( $carousel.data( 'columns' ), 10 ),
			autoplay = parseInt( $carousel.data( 'autoplay' ), 10 ),
			loop = $carousel.data( 'loop' ),
			margin = 0;

		autoplay = autoplay === 0 ? false : autoplay;
		if ($('body').hasClass('single-post')) {
			var margin = 30;
		}
		$carousel.find( '.products' ).addClass( 'owl-carousel' ).owlCarousel( {
			items          : columns,
			rtl       : deux.data.isRTL === "1",
			margin		   : margin,
			autoplay       : !!autoplay,
			autoplayTimeout: autoplay,
			loop           : loop === 'yes',
			pagination     : true,
			navigation     : false,
			slideSpeed     : 300,
			paginationSpeed: 500,
			responsive     : {
				0:{
					items:1
				},
				480:{
					items:1
				},
				767:{
					items:columns
				}
			}
		} );
	} );
	};

	/**
	 * Ajax login before refresh page
	 */

	 deux.loginModalAuthenticate = function() {
		$( '#login-modal' ).on( 'submit', '.login', function( e ) {
			var username = $( 'input[name=username]', this ).val(),
				password = $( 'input[name=password]', this ).val(),
				remember = $( 'input[name=rememberme]', this ).is( ':checked' ),
				$button = $( '[type=submit]', this ),
				$form = $( this ),
				$box = $form.prev( '.woocommerce-error' );

			if ( ! username || ! password ) {
				$( 'input[name=username]', this ).focus();

				return false;
			}

			e.preventDefault();
			$button.addClass( 'loading' );

			if ( $box.length ) {
				$box.fadeOut();
			}

			$.post(
				deux.data.ajax_url,
				{
					action: 'deux_login_authenticate',
					creds: {
						user_login: username,
						user_password: password,
						remember: remember
					}
				},
				function( response ) {
					if ( ! response.success ) {
						if ( ! $box.length ) {
							$box = $( '<div class="woocommerce-error deux-message-box danger"/>' );

							$box.append( '<svg viewBox="0 0 20 20" class="message-icon"><use xlink:href="#warning"></use></svg>' )
								.append( '<div class="box-content"></div>' )
								.append( '<a class="close" href="#"><svg viewBox="0 0 14 14"><use xlink:href="#close-delete-small"></use></svg></a>' );

							$box.hide().insertBefore( $form );
						}
						$box.find( '.box-content' ).html( response.data );
						$box.fadeIn();
						$button.removeClass( 'loading' );
					} else {
						window.location.reload();
					}
				}
			);
		} );
	};

	/**
	 * Document ready
	 */
	$( function () {
		deux.init();

	} );
 
})( jQuery );
