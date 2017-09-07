;
(function ($) {
    var Registry = function () {
        this.innerObjects = {};
    };

    $.extend(Registry.prototype, {
        get: function (key) {
            if (this.isRegistered(key)) {
                return this.innerObjects[key];
            }
            return null;
        },
        set: function (key, obj) {
            return this.innerObjects[key] = obj;
        },
        isRegistered: function (key) {
            return (this.innerObjects[key] !== undefined);
        }
    });

    $.fn.extend({
        registry: function () {
            var $this = $(this),
                data = $this.data('registry');

            if (!data) {
                $this.data('registry', (data = new Registry()));
            }

            return data;
        }
    });

    // make alias
    $.registry = function (key) {
        return (arguments.length == 2) ?
            $(window).registry().set(key, arguments[1]) :
            $(window).registry().get(key);
    };

    return Registry;
})(jQuery);