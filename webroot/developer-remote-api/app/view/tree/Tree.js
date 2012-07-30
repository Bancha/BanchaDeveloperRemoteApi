/**
 * The class tree
 */
Ext.define('Docs.view.tree.Tree', {
    extend: 'Ext.tree.Panel',
    alias : 'widget.classtree',

    cls: 'class-tree iScroll',
    useArrows: true,
    rootVisible: false,

    border: false,
    bodyBorder: false,

    initComponent: function() {
        this.addEvents(
            /**
             * @event
             * Fired when link in tree was clicked on and needs to be loaded.
             * @param {String} url  URL of the page to load
             * @param {Ext.EventObject} e
             */
            "urlclick"
        );

        // Expand the main tree
        this.root.expanded = true;
        if(this.root.children && this.root.children.length) {
            // otherwise the user just haven't exposed any models
            // he will see the appropriete notice, triggered from
            // output/bancha-api-transformer.js
            this.root.children[0].expanded = true;
        }

        this.on("itemclick", this.onItemClick, this);

        this.callParent();

    },

    onItemClick: function(view, node, item, index, e) {
        var url = node.raw ? node.raw.url : node.data.url;

        if (url) {
            if (e.getTarget(".fav")) {
                var favEl = Ext.get(e.getTarget(".fav"));
                if (favEl.hasCls('show')) {
                    Docs.Favorites.remove(url);
                }
                else {
                    Docs.Favorites.add(url, this.getNodeTitle(node));
                }
            }
            else {
                this.fireEvent("urlclick", url, e);
            }
        }
        else if (!node.isLeaf()) {
            if (node.isExpanded()) {
                node.collapse(false);
            }
            else {
                node.expand(false);
            }
        }
    },

    /**
     * Selects link node in tree by URL.
     *
     * @param {String} url
     */
    selectUrl: function(url) {
        var r = this.findRecordByUrl(url);
        if (r) {
            r.bubble(function(n) {
                n.expand();
            });
            this.getSelectionModel().select(r);
        }
        else {
            this.getSelectionModel().deselectAll();
        }
    },

    findRecordByUrl: function(url) {
        return this.getRootNode().findChildBy(function(n) {
            return url === n.raw.url;
        }, this, true);
    },

    getNodeTitle: function(node) {
        var m = node.raw.url.match(/^\/api\/(.*)$/);
        if (m) {
            return m[1];
        }
        else {
            return node.raw.text;
        }
    }

});
