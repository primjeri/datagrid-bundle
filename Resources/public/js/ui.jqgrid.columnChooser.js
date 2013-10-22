$.jgrid.extend({
    columnChooser : function(opts) {
        var self = this;
        if($("#colchooser_"+$.jgrid.jqID(self[0].p.id)).length ) { return; }
        var selector = $('<div id="colchooser_'+self[0].p.id+'" style="position:relative;overflow:hidden"><div><select multiple="multiple"></select></div></div>');
        var select = $('select', selector);

        function insert(perm,i,v) {
            if(i>=0){
                var a = perm.slice();
                var b = a.splice(i,Math.max(perm.length-i,i));
                if(i>perm.length) { i = perm.length; }
                a[i] = v;
                return a.concat(b);
            }
        }
        opts = $.extend({
            "width" : 420,
            "height" : 240,
            "classname" : null,
            "done" : function(perm) { if (perm) { self.jqGrid("remapColumns", perm, true); } },
            /* msel is either the name of a ui widget class that
             extends a multiselect, or a function that supports
             creating a multiselect object (with no argument,
             or when passed an object), and destroying it (when
             passed the string "destroy"). */
            "msel" : "multiselect",
            /* "msel_opts" : {}, */

            /* dlog is either the name of a ui widget class that 
             behaves in a dialog-like way, or a function, that
             supports creating a dialog (when passed dlog_opts)
             or destroying a dialog (when passed the string
             "destroy")
             */
            "dlog" : "dialog",

            /* dlog_opts is either an option object to be passed 
             to "dlog", or (more likely) a function that creates
             the options object.
             The default produces a suitable options object for
             ui.dialog */
            "dlog_opts" : function(opts) {
                var buttons = {};
                buttons[opts.bSubmit] = function() {
                    opts.apply_perm();
                    opts.cleanup(false);
                };
                buttons[opts.bCancel] = function() {
                    opts.cleanup(true);
                };
                return $.extend(true, {
                    "buttons": buttons,
                    "close": function() {
                        opts.cleanup(true);
                    },
                    "modal" : opts.modal ? opts.modal : false,
                    "resizable": opts.resizable ? opts.resizable : true,
                    "width": opts.width+20,
                    resize: function (e, ui) {
                        var $container = $(this).find('>div>div.ui-multiselect'),
                            containerWidth = $container.width(),
                            containerHeight = $container.height(),
                            $selectedContainer = $container.find('>div.selected'),
                            $availableContainer = $container.find('>div.available'),
                            $selectedActions = $selectedContainer.find('>div.actions'),
                            $availableActions = $availableContainer.find('>div.actions'),
                            $selectedList = $selectedContainer.find('>ul.connected-list'),
                            $availableList = $availableContainer.find('>ul.connected-list'),
                            dividerLocation = opts.msel_opts.dividerLocation || $.ui.multiselect.defaults.dividerLocation;

                        $container.width(containerWidth); // to fix width like 398.96px                     
                        $availableContainer.width(Math.floor(containerWidth*(1-dividerLocation)));
                        $selectedContainer.width(containerWidth - $availableContainer.outerWidth() - ($.browser.webkit ? 1: 0));

                        $availableContainer.height(containerHeight);
                        $selectedContainer.height(containerHeight);
                        $selectedList.height(Math.max(containerHeight-$selectedActions.outerHeight()-1,1));
                        $availableList.height(Math.max(containerHeight-$availableActions.outerHeight()-1,1));
                    }
                }, opts.dialog_opts || {});
            },
            /* Function to get the permutation array, and pass it to the
             "done" function */
            "apply_perm" : function() {
                $('option',select).each(function(i) {
                    if (this.selected) {
                        self.jqGrid("showCol", colModel[this.value].name);
                    } else {
                        self.jqGrid("hideCol", colModel[this.value].name);
                    }
                });

                var perm = [];
                //fixedCols.slice(0);
                $('option:selected',select).each(function() { perm.push(parseInt(this.value,10)); });
                $.each(perm, function() { delete colMap[colModel[parseInt(this,10)].name]; });
                $.each(colMap, function() {
                    var ti = parseInt(this,10);
                    perm = insert(perm,ti,ti);
                });
                if (opts.done) {
                    opts.done.call(self, perm);
                }
            },
            /* Function to cleanup the dialog, and select. Also calls the
             done function with no permutation (to indicate that the
             columnChooser was aborted */
            "cleanup" : function(calldone) {
                call(opts.dlog, selector, 'destroy');
                call(opts.msel, select, 'destroy');
                selector.remove();
                if (calldone && opts.done) {
                    opts.done.call(self);
                }
            },
            "msel_opts" : {}
        }, $.jgrid.col, opts || {});
        if($.ui) {
            if ($.ui.multiselect ) {
                if(opts.msel == "multiselect") {
                    if(!$.jgrid._multiselect) {
                        // should be in language file
                        alert("Multiselect plugin loaded after jqGrid. Please load the plugin before the jqGrid!");
                        return;
                    }
                    opts.msel_opts = $.extend($.ui.multiselect.defaults,opts.msel_opts);
                }
            }
        }
        if (opts.caption) {
            selector.attr("title", opts.caption);
        }
        if (opts.classname) {
            selector.addClass(opts.classname);
            select.addClass(opts.classname);
        }
        if (opts.width) {
            $(">div",selector).css({"width": opts.width,"margin":"0 auto"});
            select.css("width", opts.width);
        }
        if (opts.height) {
            $(">div",selector).css("height", opts.height);
            select.css("height", opts.height - 10);
        }
        var colModel = self.jqGrid("getGridParam", "colModel");
        var colNames = self.jqGrid("getGridParam", "colNames");
        var colMap = {}, fixedCols = [];

        select.empty();
        $.each(colModel, function(i) {
            colMap[this.name] = i;
            if (this.hidedlg) {
                if (!this.hidden) {
                    fixedCols.push(i);
                }
                return;
            }

            select.append("<option value='"+i+"' "+
                (this.hidden?"":"selected='selected'")+">"+colNames[i]+"</option>");
        });
        function call(fn, obj) {
            if (!fn) { return; }
            if (typeof fn == 'string') {
                if ($.fn[fn]) {
                    $.fn[fn].apply(obj, $.makeArray(arguments).slice(2));
                }
            } else if ($.isFunction(fn)) {
                fn.apply(obj, $.makeArray(arguments).slice(2));
            }
        }

        var dopts = $.isFunction(opts.dlog_opts) ? opts.dlog_opts.call(self, opts) : opts.dlog_opts;
        call(opts.dlog, selector, dopts);
        var mopts = $.isFunction(opts.msel_opts) ? opts.msel_opts.call(self, opts) : opts.msel_opts;
        call(opts.msel, select, mopts);
        // fix height of elements of the multiselect widget
        var resizeSel = "#colchooser_"+$.jgrid.jqID(self[0].p.id),
            $container = $(resizeSel + '>div>div.ui-multiselect'),
            $selectedContainer = $(resizeSel + '>div>div.ui-multiselect>div.selected'),
            $availableContainer = $(resizeSel + '>div>div.ui-multiselect>div.available'),
            containerHeight,
            $selectedActions = $selectedContainer.find('>div.actions'),
            $availableActions = $availableContainer.find('>div.actions'),
            $selectedList = $selectedContainer.find('>ul.connected-list'),
            $availableList = $availableContainer.find('>ul.connected-list');
        $container.height($container.parent().height()); // increase the container height
        containerHeight = $container.height();
        $selectedContainer.height(containerHeight);
        $availableContainer.height(containerHeight);
        $selectedList.height(Math.max(containerHeight-$selectedActions.outerHeight()-1,1));
        $availableList.height(Math.max(containerHeight-$availableActions.outerHeight()-1,1));
        // extend the list of components which will be also-resized
        selector.data('dialog').uiDialog.resizable("option", "alsoResize",
            resizeSel + ',' + resizeSel +'>div' + ',' + resizeSel + '>div>div.ui-multiselect');
    }
});