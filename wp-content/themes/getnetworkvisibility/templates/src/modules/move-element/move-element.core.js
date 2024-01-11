(function ($) {
    const FP_MOVE_ELEMENT = 'fp.move.element';

    /**
     *
     * @param $element
     * @param $options
     * @returns {FpMoveElement}
     * @constructor
     */
    function FpMoveElement($element, $options) {
        const $this = this;

        $this.element = $($element);
        $this.options = $.extend($this.options, FpMoveElement.prototype.DEFAULTS, $options);

        const $orderElements = $($this.element).find($this.options.moveElement);

        if ($orderElements.length) {
            let $dataIndex = 0;

            for (let $e of $orderElements) {
                $($e).attr('data-index', $dataIndex++);
            }
        }

        $this.order = $orderElements.length > 0;
        $this.totalChilds = $this.order ? $orderElements.length : 0;

        $this.init();

        return $this;
    }

    /**
     *
     * @type {{moveElement: string}}
     */
    FpMoveElement.prototype.DEFAULTS = {
        targetEvent: '[data-target]',
        moveElement: null,
        appendClass: 'moved',
        maxElementMoved: 0,
    };

    FpMoveElement.prototype.init = function () {
        const $this = this;

        $this.addEventListeners();
    }

    FpMoveElement.prototype.addEventListeners = function () {
        const $this = this;

        const $targetEvent = $this.options.targetEvent ?? $this.options.moveElement;

        $($this.element).find($targetEvent).on('click', function ($event) {
            $this.click($event);
        });
    }

    FpMoveElement.prototype.click = function ($event) {
        $event.preventDefault();

        const $this = this;
        const $target = $($event.currentTarget);
        const $elementForMoved = $this.options.moveElement && $this.options.moveElement !== $this.options.targetEvent ? $target.closest($this.options.moveElement) : $target;
        const $moved = eval($elementForMoved.attr('data-element-moved'));

        if ($this.options.maxElementMoved > 0 && !$moved && $($this.element).find('[data-element-moved=true]').length === $this.options.maxElementMoved) {
            return;
        }

        if (!$moved) {
            $elementForMoved.attr('data-element-moved', true);
            $this.element.prepend($elementForMoved);
        }

        if ($moved) {
            $elementForMoved.attr('data-element-moved', false);

            if ($this.order) {
                const $orderNumber = $elementForMoved.data('index');

                if (($this.totalChilds - 1) > $orderNumber) {
                    const $indexElements = $($this.element).find('[data-index]:not([data-element-moved=true])');
                    let $position = $this.totalChilds;

                    for (let $el of $indexElements) {
                        const $orderIndex = $($el).data('index');

                        if ($orderNumber < $orderIndex) {
                            break;
                        }

                        $position = $orderIndex;
                    }

                    $elementForMoved.insertAfter($this.element.find(`[data-index=${$position}]`));
                } else {
                    $elementForMoved.appendTo($this.element);
                }
            }

            if (!$this.order) {
                $elementForMoved.appendTo($this.element);
            }
        }

        if ($this.options.appendClass) {
            $elementForMoved.toggleClass($this.options.appendClass);
        }
    }

    /**
     *
     * @param $opts
     * @returns {Window.jQuery|*|jQuery|HTMLElement}
     */
    $.fn.moveElement = function ($opts) {

        if ($opts.moveElement === undefined || !$opts.moveElement) {
            $.error(`Not found 'moveElement' setting!`);
        }

        const $this = $(this);

        if (!$this.length) {
            return $this;
        }

        const $typeofOpts = typeof $opts === 'object';
        let $instance = $this.data(FP_MOVE_ELEMENT);

        if ($typeofOpts || !$opts) {
            $instance = new FpMoveElement($this, $opts);
            $this.data(FP_MOVE_ELEMENT, $instance);

            return this;
        }

        if (!$instance) {
            $.error(`Plugin must be initialised before using method: ${$opts}`);
        }

        if (!$typeofOpts && $opts.indexOf('_') === 0) {
            $.error(`Method ${opts} is private!`);
        }

        if ($instance && !($opts in $instance)) {
            $.error(`Method ${$opts} does not exist!`);
        }

        let args = Array.prototype.slice.call(arguments, 1);

        return $instance[$opts](...args);
    };

})(window.jQuery);