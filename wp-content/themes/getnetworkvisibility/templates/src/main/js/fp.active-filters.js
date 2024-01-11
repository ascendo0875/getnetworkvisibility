(function ($) {
    const FP_ACTIVE_FILTERS = 'fp.activeFilters';

    function ActiveFilters(element, options) {
        this.element = $(element);
        this.options = $.extend(this.options, ActiveFilters.prototype.DEFAULTS, options);
        this.init();

        return this;
    }

    ActiveFilters.prototype.DEFAULTS = {
        onChange: function () {
        }, search: null, filters: [], forceRemoveFilters: false
    };

    ActiveFilters.prototype.init = function () {
        let self = this;

        if (self.options.search) {
            self.addSearchFilter();
        }

        if (self.options.filters) {
            const filters = self.options.filters;
            self.options.filters = [];

            filters.map((key, filter) => {
                let value = filter;
                let label = $(`label[for=${filter.id}]`).text().trim();

                self.addFilter({label, value});
            });
        }

        self.options.search.on('change', function (event) {
            if (!event.target.value.trim()) {
                self.removeSearchFilter();
            }
        });

        document.addEventListener(`${FP_ACTIVE_FILTERS}.removeAllFilters`, function () {
            self.removeAllFilters();
        })
    }

    ActiveFilters.prototype.removeAllFilters = function () {
        this.options.forceRemoveFilters = true;

        this.options.filters.map($filter => {
            $($filter.element).trigger('click');
        });

        this.removeSearchFilter();

        this.options.forceRemoveFilters = false;
    }

    ActiveFilters.prototype.addSearchFilter = function () {
        let self = this;

        if (arguments && arguments[0] && typeof arguments[0]) {
            self.options.search = arguments[0];
        }

        if (self.options.search) {
            let value = self.options.search.val();

            if (!self.options.search.isActiveFilter) {
                let $searchElement = self._applyFilter(value, function (event) {
                    event.preventDefault();

                    self.options.search.val('');
                    self.options.search.isActiveFilter = false;

                    $(this).remove();

                    if (!self.options.forceRemoveFilters) {
                        self.options.onChange();
                    }
                });

                if ($searchElement) {
                    self.options.search.elementActiveFilter = $searchElement;
                }
            }

            self.options.search.isActiveFilter = self.options.search.val().trim().length > 0;
        }
    }

    ActiveFilters.prototype.removeSearchFilter = function () {
        let self = this;

        if (self.options.search) {
            $(self.options.search.elementActiveFilter).trigger('click');
        }
    }

    ActiveFilters.prototype.addFilter = function ($filter) {
        let existingFilter = this.options.filters.find(filter => filter.label === $filter && filter.value === $filter.value);

        if (!existingFilter) {
            let filter = this._applyFilter($filter.label);

            if (filter) {
                $filter.element = filter;
                this.options.filters.push($filter);
            }
        }
    };

    ActiveFilters.prototype.removeFilter = function ($filter) {
        let $filters = [];

        this.options.filters.map(filter => {
            if ($filter === filter.value) {

                if (filter.element) {
                    $(filter.element).trigger('click');
                }

            } else {
                $filters.push(filter);
            }
        });

        this.options.filters = $filters;
    }

    ActiveFilters.prototype._applyFilter = function (value, callBack = undefined) {
        let self = this;

        if (!callBack) {
            callBack = function (event) {
                event.preventDefault();

                let $element = self.options.filters.find(filter => filter.element === event.currentTarget);

                if ($element && ('value' in $element)) {
                    $element.value.checked = false;
                }

                $(this).remove();
                if (!self.options.forceRemoveFilters) {
                    self.options.onChange();
                }
            };
        }

        if (value) {
            let a = document.createElement('a');
            a.onclick = callBack;
            a.innerText = value;

            $(a).appendTo(this.element);

            return a;
        }

        return false;
    }

    $.fn.activeFilters = function (opts) {
        let $this = $(this);

        if (!$this.length) {
            return $this;
        }

        let instance = $this.data(FP_ACTIVE_FILTERS);

        if (typeof opts === 'object' || !opts) {
            instance = new ActiveFilters($this, opts);
            $this.data(FP_ACTIVE_FILTERS, instance);

            return this;
        }

        if (!instance) {
            $.error(`Plugin must be initialised before using method: ${opts}`);
        }

        if (typeof opts !== "object" && opts.indexOf('_') === 0) {
            $.error(`Method ${opts} is private!`);
        }

        if (instance && !(opts in instance)) {
            $.error(`Method ${opts} does not exist!`);
        }

        let args = Array.prototype.slice.call(arguments, 1);

        return instance[opts](...args);
    };
})(window.jQuery);