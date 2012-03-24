/**
 * List of classes on front page.
 * Together with links to guides and icons legend.
 */
Ext.define('Docs.view.index.Container', {
    extend: 'Ext.container.Container',
    alias : 'widget.indexcontainer',
    cls: 'class-list',

    initComponent: function() {
        this.tpl = new Ext.XTemplate(
            '<h1 class="top">{title}</h1>',
            '<tpl if="notice">',
                '<div class="notice">{notice}</div>',
            '</tpl>',
            '<p class="api-intro">Welcome to the Bancha Remote API Documentation. ',
            'To view all remotely availabel methods from any controller please ',
            'click on one of the classes on the left side.</p>',
            '<div class="section legend">',
                '<h4>Legend</h4>',
                '<ul>',
                    '<li class="icon icon-crud-controller">Support for one or more standard CRUD methods</li>',
                    '<li class="icon icon-remotable-controller">Exposes non-CRUD controller methods</li>',
                    '<li class="icon icon-crud-remotable-controller">Support both from above</li>',
                '</ul>',
            '</div>'
        );
        this.data = this.extractData();
        
        this.callParent(arguments);
    },

    // Extracts HTML from hidden elements in page
    extractData: function() {
        var data = {
            notice: Ext.get("notice-text"),
            guides: Ext.get("guides-content"),
            categories: Ext.get("categories-content")
        };
        for (var i in data) {
            var el = data[i];
            if (el) {
                // If page contains the div then extract its contents,
                // after that remove the original
                data[i] = el.dom.innerHTML;
                el.remove();
            }
        }
        // Extract <title> text
        data.title = Ext.query("title")[0].innerHTML;
        return data;
    }
});
