
// catch every debug exception thrown from either ExtJS or Bancha
Ext.Error.handle = function(err) {
    Ext.Msg.alert('Error', err.msg);
};

// catch server-side errors
Ext.direct.Manager.on('exception', function(err){
	if(err.code==="parse") {
		// parse error
		Ext.Msg.alert('Bancha: Server-Response can not be decoded',err.data.msg);
	} else {
		// exception from server
		Ext.Msg.alert('Bancha: Exception from Server',
			"<br/><b>"+(err.exceptionType || "Exception")+": "+err.message+"</b><br /><br />"+
			((err.where) ? err.where+"<br /><br />Trace:<br />"+err.trace : "<i>Turn on the debug mode in cakephp to see the trace.</i>"));
	}
});




Ext.ns("Docs");

Ext.Loader.setConfig({
    enabled: true,
    paths: {
        'Docs': 'developer-remote-api/app'
    }
});

Ext.require('Docs.view.Viewport');
Ext.require('Ext.form.field.Trigger');
Ext.require('Ext.tab.Panel');
Ext.require('Ext.grid.column.Action');
Ext.require('Ext.grid.plugin.DragDrop');
Ext.require('Ext.layout.container.Border');
Ext.require('Ext.data.TreeStore');

// The following is exactly what Ext.application() function does, but
// we use our own Application class that extends Ext.app.Application

Ext.require('Docs.Application');

Ext.onReady(function() {
    Ext.create('Docs.Application');
});