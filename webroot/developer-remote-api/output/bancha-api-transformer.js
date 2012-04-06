


// Transform Bancha Remote API data into tree structure
var classes = [];
Ext.Object.each(Bancha.REMOTE_API.actions, function(className,methods) {
	
	// ignore Bancha
	if(className==='Bancha') {
		return;
	}
	
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
        url: '/api/'+className,
        leaf: true
     });
});

Docs.classData = {
    "text": "API Documentation",
    "iconCls": "icon-docs",
    "id": "apidocs",
    "children": classes
};


// build search data, add controller
var searchData = Ext.Array.map(classes, function(el) {
	return {
        "type": "cls", /* defined the icon */
        "member": el.text, /* display text */
        "desc" : '',
        "cls": el.text, /* used for building the url */
        "xtypes": []
	}
});

Ext.Object.each(Bancha.REMOTE_API.actions, function(className,methods) {
	Ext.Array.each(methods, function(method) {
		searchData.push({
        	"type": "method",
        	"member": method.name,
            "desc" : className+'.'+method.name+(method.formHandler ? ' @formHandler' : ''),
        	"cls": className,
        	"xtypes": []
      	});
	});
});

Docs.searchData = {
    "data": searchData
};