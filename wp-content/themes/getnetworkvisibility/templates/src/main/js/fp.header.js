import { TweenLite, TimelineLite, Power2 } from '../../../tools/node_modules/gsap/dist/gsap';
import { isSmall } from "./fp.breakpoint";
import {FPMessenger} from "../../modules/messenger/fp.messenger";
import '../../../tools/node_modules/waypoints/lib/jquery.waypoints';
import '../../../tools/node_modules/waypoints/lib/shortcuts/sticky.min';
import '../../../tools/node_modules/smoothscroll-for-websites/SmoothScroll';



$(document).ready(function(){

	new Header();

});


class Header extends FPMessenger{

	isMenuOpen = false;
	globalMobileNav  = $('.global-mobile-nav');
	menuButton  = $('.mobile-nav a');

	constructor() {
		super();

		const self = this;

		this.bind();

	}

	subOpen(item){
		const $parentElement = $($(item).closest('ul'));
		const $li = [];

		$parentElement.find('li.open').each(($index, $element) => {
			$li.push($($element));
		});

		if($li.length > 0) {
			$($li).not(item).stop().each(($index, $element) => {
				$($element).removeClass('open');
			});
		}

		$('.sub-menu', item).slideDown('fast');
		$('body').addClass('menu-open');

		$(item).addClass('open');
	}

	subClose(item){
		$('.sub-menu', item).slideUp('fast');
		$('body').removeClass('menu-open');
		$(item).removeClass('open');
	}

	subItemClicked(item){
		if($(item).hasClass('open')){
			this.subClose(item);
		}else{
			this.subOpen(item);
		}

		return false;
	}

	setupGlobalMobileNav() {
		var topPadding = 0;
		// topPadding += (isSmall()) ? $('.site-header').outerHeight() : $('.wrapper.sticky').outerHeight();
		if($('.alert-bar').length > 0){
			topPadding += $('.alert-bar').outerHeight();
		}
		if($('.site-header').length > 0){
			topPadding += $('.site-header').outerHeight();
		}
		$('.global-mobile-nav').css('top', topPadding + 'px');
	}

	openMenu(){

		if(!this.isMenuOpen){
			var t = new TimelineLite();

			//TweenLite.set(this.globalMobileNav.css('right', ((isSmall()) ? '-100%' : '0')), {x : this.globalMobileNav.width()});
			this.setupGlobalMobileNav();
			//TweenLite.set(this.globalMobileNav, {x : this.globalMobileNav.width()}, 0);
			t.clear();
			//t.to(this.globalMobileNav, .35, {x : ((isSmall()) ? '-100%' : '0'), ease: Power2.easeOut}, 0);
			$('body').addClass('menu-open');
			this.menuButton.addClass('open');


			this.isMenuOpen = true;
		}
	}

	closeMenu(){
		if(this.isMenuOpen){
			var t = new TimelineLite();
			const self = this;

			t.clear();
			//t.to(this.globalMobileNav, .25, {x : this.globalMobileNav.width(), ease: Power2.easeIn}, 0);
			// setTimeout(function(){
			// 	TweenLite.set(self.globalMobileNav, {x : '-100%'}, 0);
			// }, 500);
			$('body').removeClass('menu-open');
			this.menuButton.removeClass('open');

			self.isMenuOpen = false;
		}
	}

	toggleMenu(){
		const self = this;

		if(self.isMenuOpen){
			this.closeMenu()
		}else{
			this.openMenu();
		}

	}

	bind(){
		const self = this;

		$('.global-mobile-nav > div > ul').on('fp.navigation.binds', function($event) {
			$('.global-mobile-nav > div > ul > li.menu-item-has-children.current-menu-item').each(function () {
				$(this).trigger('click');
			});
		});

		$('li.not-clickable > a').on('click', function ($event) {
			$event.preventDefault();
			if(isSmall() || (!isSmall() && !this.closest('.sitemap'))) {
				if (this.closest('ul') && $(this.closest('ul')).data('fp.navigation')) {
					$(this.closest('ul')).menuNavigation('itemClicked', $(this.closest('li')));
				}
			}
		});

		// $('.navigation > ul, .global-mobile-nav > div > ul').on('fp.navigation.init', function () {
		// 	new Waypoint.Sticky({
		// 		element		: $('.site-header .wrapper')[0],
		// 		stuckClass  : 'sticky',
		// 		offset		: (isSmall()) ? '0px' : '-5px',
		// 		handler      : function (direction) {
		// 			if(direction === 'up' && !isSmall()){
		// 				self.closeMenu();
		// 			}
		// 		}
		//
		// 	});
		// });

		$(document).on('click', 'a.back[data-parent-controls]', function ($event) {
			$event.preventDefault();
			const $elementTarget = $($event.target);
			const $controls = $elementTarget.data('parent-controls');
			const $parent = $elementTarget.closest($controls);

			if($parent.length > 0) {
				$($parent).each(function($index, $element) {
					$($element).removeClass('open');
				});
			}
		});

		// this.setupGlobalMobileNav();
		//
		// $(window).resize(function(){
		// 	self.setupGlobalMobileNav();
		// });

	}

}





