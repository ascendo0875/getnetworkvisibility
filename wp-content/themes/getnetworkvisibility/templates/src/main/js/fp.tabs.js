/*

<ul class="tabs">
    <li class="active"><a href="#" fp-tabs-trigger="t1" fp-tabs-links="group">T1</a></li>
    <li><a href="#" fp-tabs-trigger="t2" fp-tabs-links="group">Competitions</a>T2</li>
    <li><a href="#" fp-tabs-trigger="t3" fp-tabs-links="group">T3</a></li>
    <li><a href="#" fp-tabs-trigger="t4" fp-tabs-links="group">T4</a></li>
</ul>

<div fp-tabs-content="group" fp-tabs-id="t1">
</div>

<div fp-tabs-content="group" fp-tabs-id="t2">
</div>

<div fp-tabs-content="group" fp-tabs-id="t3">
</div>

<div fp-tabs-content="group" fp-tabs-id="t4">
</div>


*/

document.addEventListener('userIsInteracting', function (e) {

    new FPTabs();

    function FPTabs(opts) {
        var defaults = {
            trigger_prop: 'fp-tabs-trigger',
            container_prop: 'fp-tabs-links',
            content_prop: 'fp-tabs-content',
            tab_id_prop: 'fp-tabs-id'
        }

        opts = $.extend(defaults, opts);
        this.trigger_prop = opts.trigger_prop;
        this.container_prop = opts.container_prop;
        this.content_prop = opts.content_prop;
        this.tab_id_prop = opts.tab_id_prop;
        this.areas = [];
        this.items = [];

        this.bind = function () {
            var self = this;
            $('[' + this.trigger_prop + ']').click(function () {
                self.openTab($(this).attr(self.trigger_prop), $(this).attr(self.container_prop), $(this).parent());

                return false;
            })
        }

        this.openTab = function (id, set, tab_element) {
            if (!$(tab_element).hasClass('active')) {
                $('[' + this.trigger_prop + ']').each(function () {
                    $(this).parent().removeClass('active');
                });
                $(tab_element).addClass('active');
                $('[' + this.tab_id_prop + '="' + id + '"]').insertBefore($('[' + this.content_prop + '="' + set + '"]').first());
                $('[' + this.content_prop + '="' + set + '"]').slideUp(300);
                $('[' + this.tab_id_prop + '="' + id + '"]').slideDown(300);
            }
        }

        this.init = function () {
            this.bind();

        }

        this.init();
    }

}, false);