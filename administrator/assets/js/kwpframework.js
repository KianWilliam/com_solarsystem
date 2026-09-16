/** JS KWP Framework **/
/*
* March 2019
* Cédric KEIFLIN
* https://www.joomlakwp.fr - https://www.template-creator.com
* @version		1.0.0 
*/

$kwp = window.$kwp || jQuery.noConflict();

KWPApi = window.KWPApi || {};

/**
 * 
 * Text
 */
(function () {
	'use strict';
	//BC compatibility with KWPApi.Text
	var strings = strings || {}
	if (typeof KWPApi.Text == 'undefined') {
//		KWPApi.Text = {};
		KWPApi.Text = {
			strings:   {},

			/**
			 * Translates a string into the current language.
			 *
			 * @param {String} key   The string to translate
			 * @param {String} def   Default string
			 *
			 * @returns {String}
			 */
			'_': function( key, def ) {

				// Chekwp for new strings in the optionsStorage, and load them
				var newStrings = KWPApi.Text.getOptions('kwpapi.text');
				if ( newStrings ) {
					this.load(newStrings);

					// Clean up the optionsStorage from useless data
					KWPApi.Text.loadOptions({'kwpapi.text': null});
				}

				def = def === undefined ? '' : def;
				key = key.toUpperCase();

				return this.strings[ key ] !== undefined ? this.strings[ key ] : def;
			},

			/**
			 * Load new strings in to KWPApi.Text.JText
			 *
			 * @param {Object} object  Object with new strings
			 * @returns {KWPApi.Text.JText}
			 */
			load: function( object ) {
				for ( var key in object ) {
					if (!object.hasOwnProperty(key)) continue;
					this.strings[ key.toUpperCase() ] = object[ key ];
				}

				return this;
			}
		};
//		KWPApi.Text.JText = KWPApi.Text.Text;

		KWPApi.Text.optionsStorage = KWPApi.Text.optionsStorage || null;

		KWPApi.Text.getOptions = function( key, def ) {
			// Load options if they not exists
			if (!KWPApi.Text.optionsStorage) {
				KWPApi.Text.loadOptions();
			}

			return KWPApi.Text.optionsStorage[key] !== undefined ? KWPApi.Text.optionsStorage[key] : def;
		};

		KWPApi.Text.loadOptions = function( options ) {
			// Load form the script container
			if (!options) {
				var elements = document.querySelectorAll('.joomla-script-options.new'),
					str, element, option, counter = 0;

				for (var i = 0, l = elements.length; i < l; i++) {
					element = elements[i];
					str     = element.text || element.textContent;
					option  = JSON.parse(str);

					if (option) {
						KWPApi.Text.loadOptions(option);
						counter++;
					}

					element.className = element.className.replace(' new', ' loaded');
				}

				if (counter) {
					return;
				}
			}

			// Initial loading
			if (!KWPApi.Text.optionsStorage) {
				KWPApi.Text.optionsStorage = options || {};
			}
			// Merge with existing
			else if ( options ) {
				for (var p in options) {
					if (options.hasOwnProperty(p)) {
						KWPApi.Text.optionsStorage[p] = options[p];
					}
				}
			}
		};
	}
	else {
		KWPApi.Text.load(strings);
	}

})();


/* ===========================================================
 * bootstrap-tooltip.js v2.3.2
 * http://twitter.github.com/bootstrap/javascript.html#tooltips
 * Inspired by the original jQuery.tipsy by Jason Frame
 * ===========================================================*/

/**
 * 
 * Tooltip
 */
!function ($) {

  "use strict"; // jshint ;_;


 /* TOOLTIP PUBLIC CLASS DEFINITION
  * =============================== */

var Tooltipkwp = function (element, options) {
  this.init('kwptooltip', element, options)
}

  Tooltipkwp.prototype = {

    constructor: Tooltipkwp

  , init: function (type, element, options) {
      var eventIn
        , eventOut
        , triggers
        , trigger
        , i

      this.type = type
      this.$element = $(element)
      this.options = this.getOptions(options)
      this.enabled = true

      triggers = this.options.trigger.split(' ')

      for (i = triggers.length; i--;) {
        trigger = triggers[i]
        if (trigger == 'click') {
          this.$element.on('click.' + this.type, this.options.selector, $.proxy(this.toggle, this))
        } else if (trigger != 'manual') {
          eventIn = trigger == 'hover' ? 'mouseenter' : 'focus'
          eventOut = trigger == 'hover' ? 'mouseleave' : 'blur'
          this.$element.on(eventIn + '.' + this.type, this.options.selector, $.proxy(this.enter, this))
          this.$element.on(eventOut + '.' + this.type, this.options.selector, $.proxy(this.leave, this))
        }
      }

      this.options.selector ?
        (this._options = $.extend({}, this.options, { trigger: 'manual', selector: '' })) :
        this.fixTitle()
    }

  , getOptions: function (options) {
      options = $.extend({}, $.fn[this.type].defaults, this.$element.data(), options)

      if (options.delay && typeof options.delay == 'number') {
        options.delay = {
          show: options.delay
        , hide: options.delay
        }
      }

      return options
    }

  , enter: function (e) {
      var defaults = $.fn[this.type].defaults
        , options = {}
        , self

      this._options && $.each(this._options, function (key, value) {
        if (defaults[key] != value) options[key] = value
      }, this)

      self = $(e.currentTarget)[this.type](options).data(this.type)

      if (!self.options.delay || !self.options.delay.show) return self.show()

      clearTimeout(this.timeout)
      self.hoverState = 'in'
      this.timeout = setTimeout(function() {
        if (self.hoverState == 'in') self.show()
      }, self.options.delay.show)
    }

  , leave: function (e) {
      var self = $(e.currentTarget)[this.type](this._options).data(this.type)

      if (this.timeout) clearTimeout(this.timeout)
      if (!self.options.delay || !self.options.delay.hide) return self.hide()

      self.hoverState = 'out'
      this.timeout = setTimeout(function() {
        if (self.hoverState == 'out') self.hide()
      }, self.options.delay.hide)
    }

  , show: function () {
      var $tip
        , pos
        , actualWidth
        , actualHeight
        , placement
        , tp
        , e = $.Event('show')

      if (this.hasContent() && this.enabled) {
        this.$element.trigger(e)
        if (e.isDefaultPrevented()) return
        $tip = this.tip()
        this.setContent()

        if (this.options.animation) {
          $tip.addClass('fade')
        }

        placement = typeof this.options.placement == 'function' ?
          this.options.placement.call(this, $tip[0], this.$element[0]) :
          this.options.placement

        $tip
          .detach()
          .css({ top: 0, left: 0, display: 'block' })

        this.options.container ? $tip.appendTo(this.options.container) : $tip.insertAfter(this.$element)

        pos = this.getPosition()

        actualWidth = $tip[0].offsetWidth
        actualHeight = $tip[0].offsetHeight

        switch (placement) {
          case 'bottom':
            tp = {top: pos.top + pos.height, left: pos.left + pos.width / 2 - actualWidth / 2}
            break
          case 'top':
            tp = {top: pos.top - actualHeight, left: pos.left + pos.width / 2 - actualWidth / 2}
            break
          case 'left':
            tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left - actualWidth}
            break
          case 'right':
            tp = {top: pos.top + pos.height / 2 - actualHeight / 2, left: pos.left + pos.width}
            break
        }

        this.applyPlacement(tp, placement)
        this.$element.trigger('shown')
      }
    }

  , applyPlacement: function(offset, placement){
      var $tip = this.tip()
        , width = $tip[0].offsetWidth
        , height = $tip[0].offsetHeight
        , actualWidth
        , actualHeight
        , delta
        , replace

      $tip
        .offset(offset)
        .addClass(placement)
        .addClass('in')

      actualWidth = $tip[0].offsetWidth
      actualHeight = $tip[0].offsetHeight

      if (placement == 'top' && actualHeight != height) {
        offset.top = offset.top + height - actualHeight
        replace = true
      }

      if (placement == 'bottom' || placement == 'top') {
        delta = 0

        if (offset.left < 0){
          delta = offset.left * -2
          offset.left = 0
          $tip.offset(offset)
          actualWidth = $tip[0].offsetWidth
          actualHeight = $tip[0].offsetHeight
        }

        this.replaceArrow(delta - width + actualWidth, actualWidth, 'left')
      } else {
        this.replaceArrow(actualHeight - height, actualHeight, 'top')
      }

      if (replace) $tip.offset(offset)
    }

  , replaceArrow: function(delta, dimension, position){
      this
        .arrow()
        .css(position, delta ? (50 * (1 - delta / dimension) + "%") : '')
    }

  , setContent: function () {
      var $tip = this.tip()
        , title = this.getTitle()

		$tip.css('z-index', this.options.zindex);
      $tip.find('.kwptooltip-inner')[this.options.html ? 'html' : 'text'](title)
      $tip.removeClass('fade in top bottom left right')
    }

  , hide: function () {
	  // JOOMLA JUI >>>
	  /* ORIGINAL:
      var that = this
        , $tip = this.tip()
        , e = $.Event('hide')
      */
      var that = this
        , $tip = this.tip()
        , e = $.Event('hideme')
      // < KWPApi.Text JUI

      this.$element.trigger(e)
      if (e.isDefaultPrevented()) return

      $tip.removeClass('in')

      function removeWithAnimation() {
        var timeout = setTimeout(function () {
          $tip.off($.support.transition.end).detach()
        }, 500)

        $tip.one($.support.transition.end, function () {
          clearTimeout(timeout)
          $tip.detach()
        })
      }

      $.support.transition && this.$tip.hasClass('fade') ?
        removeWithAnimation() :
        $tip.detach()

      this.$element.trigger('hidden')

      return this
    }

  , fixTitle: function () {
      var $e = this.$element
      if ($e.attr('title') || typeof($e.attr('data-original-title')) != 'string') {
        $e.attr('data-original-title', $e.attr('title') || '').attr('title', '')
      }
    }

  , hasContent: function () {
      return this.getTitle()
    }

  , getPosition: function () {
      var el = this.$element[0]
      return $.extend({}, (typeof el.getBoundingClientRect == 'function') ? el.getBoundingClientRect() : {
        width: el.offsetWidth
      , height: el.offsetHeight
      }, this.$element.offset())
    }

  , getTitle: function () {
      var title
        , $e = this.$element
        , o = this.options

      title = $e.attr('data-original-title')
        || (typeof o.title == 'function' ? o.title.call($e[0]) :  o.title)

      return title
    }

  , tip: function () {
      return this.$tip = this.$tip || $(this.options.template)
    }

  , arrow: function(){
      return this.$arrow = this.$arrow || this.tip().find(".kwptooltip-arrow")
    }

  , validate: function () {
      if (!this.$element[0].parentNode) {
        this.hide()
        this.$element = null
        this.options = null
      }
    }

  , enable: function () {
      this.enabled = true
    }

  , disable: function () {
      this.enabled = false
    }

  , toggleEnabled: function () {
      this.enabled = !this.enabled
    }

  , toggle: function (e) {
      var self = e ? $(e.currentTarget)[this.type](this._options).data(this.type) : this
      self.tip().hasClass('in') ? self.hide() : self.show()
    }

  , destroy: function () {
      this.hide().$element.off('.' + this.type).removeData(this.type)
    }

  }


 /* TOOLTIP PLUGIN DEFINITION
  * ========================= */

  var old = $.fn.kwptooltip

  $.fn.kwptooltip = function ( option ) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('kwptooltip')
        , options = typeof option == 'object' && option
      if (!data) $this.data('kwptooltip', (data = new Tooltipkwp(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  $.fn.kwptooltip.Constructor = Tooltipkwp

  $.fn.kwptooltip.defaults = {
    animation: true
  , placement: 'top'
  , selector: false
  , template: '<div class="kwptooltip"><div class="kwptooltip-arrow"></div><div class="kwptooltip-inner"></div></div>'
  , trigger: 'hover focus'
  , title: ''
  , delay: 100
  // JOOMLA JUI >>>
  /* ORIGINAL:
  , html: false
  */
  , html: true
  // < KWPApi.Text JUI
  , container: "body"
  , zindex: "10030"
  }


 /* KWP API CALL
  * =================== */
KWPApi.Tooltip = function(el, options) { $(el).kwptooltip(options); };

 /* TOOLTIP NO CONFLICT
  * =================== */

  $.fn.kwptooltip.noConflict = function () {
    $.fn.kwptooltip = old
    return this
  }

}(window.jQuery);