/**
 * Renders class name and icon in page header.
 */
Ext.define('Docs.view.cls.Header', {
    extend: 'Ext.container.Container',
    padding: '5 0 17 0',
    // Initially the component will be empty and so the initial height
    // will not be correct if not set explicitly
    height: 47,
    alias: 'widget.classheader',

    initComponent: function() {
        this.tpl = Ext.create('Ext.XTemplate',
            '<h1 class="class" style="background: url(resources/images/header-icons/{type}.png) no-repeat 0 -8px">{name}',
                '<tpl if="type !== \'remotable-controller\'">',
                    '<span>{[this.getCrudMethods(values.crud)]}</span>',
                '</tpl>',
            '</h1>',
            {
                getCrudMethods: function(methods) {
					var supports = '',
						create = false,
						read = false,
						update = false,
						destroy = false;

					if(methods.length===0) {
						return '';
					}
					
					// iterate through all methods
					for(var method in methods) {
						if(methods.hasOwnProperty(method)) {
                    		if (methods[method].name === 'create')  create = true;
                    		if (methods[method].name === 'read')    read = true;
                    		if (methods[method].name === 'update')  update = true;
                    		if (methods[method].name === 'destroy') destroy = true;
                    	}
                    }
                    
                    // make a nice, ordered output
                    if (create) {
                        supports += "Create ";
                    }
                    if (read) {
                        supports += "Read ";
                    }
                    if (update) {
                        supports += "Update ";
                    }
                    if (destroy) {
                        supports += "Destroy ";
                    }

                    return supports;
                }
            }
        );
        this.callParent();
    },

    /**
     * Loads class name and icon to header.
     * @param {Object} cls  class config.
     */
    load: function(cls) {
        this.update(this.tpl.apply(cls));
    }
});
