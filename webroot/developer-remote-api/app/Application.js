/**
 * Main application definition for Docs app.
 *
 * We define our own Application class because this way we can also
 * easily define the dependencies.
 */
Ext.define('Docs.Application', {
    extend: 'Ext.app.Application',
    name: 'Docs',
	appFolder: 'developer-remote-api/app',
	
    requires: [
        'Docs.History',
        'Docs.Settings'
    ],

    uses: [
        'Ext.util.History',
        'Ext.data.JsonP'
    ],

    controllers: [
        'Classes',
        'Search'
    ],

    launch: function() {
        Docs.App = this;
        Docs.Settings.init();

        Ext.create('Docs.view.Viewport');

        Docs.History.init();

        // When google analytics event tracking script present on page
        if (Docs.initEventTracking) {
            Docs.initEventTracking();
        }
    }

});
