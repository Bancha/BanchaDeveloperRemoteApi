


// Transform Bancha Remote API data into tree structure
var classes = [];
Ext.Object.each(Bancha.REMOTE_API.actions, function(className,methods) {
    // iterate through all methods
    var crud = false,
    	remotable = false,
    	type;
	for(var method in methods) {
		if(methods.hasOwnProperty(method)) {
			if (methods[method].name === 'create' || methods[method].name === 'read' || 
				methods[method].name === 'update' || methods[method].name === 'destroy' ||
				methods[method].name === 'getAll' || methods[method].name === 'submit') {
				crud = true;
			} else {
				remotable = true;
			}
        }
    }
    type = crud ? (remotable ? 'crud-remotable-controller' : 'crud-controller') : 'remotable-controller';
    
    classes.push({
        text: className,
        iconCls: 'icon-'+type,
        url: '/controller/'+className,
        leaf: true
     });
});

Docs.classData = {
    "text": "API Documentation",
    "iconCls": "icon-docs",
    "id": "apidocs",
    "children": classes
};