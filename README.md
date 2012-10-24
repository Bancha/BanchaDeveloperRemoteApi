[![Bancha logo](http://docs.banchaproject.com/wiki/images/github-logo.png)](http://banchaproject.com)

API-Viewer for JS Developers
=============================

This Add-On for Bancha helps Developer-Teams in the process of creating Bancha Applications. JavaScript Frontend Developers no longer have to dig through any PHP code to find the available remote methods.

Instead they just open _/developer-remote-api.html_ in debug mode in their browser and can view all remotely available CakePHP Controller methods.

### Features:

 - Dynamically reflects on CakePHP app
 - Displays searchable RemoteStubs
 - Uses both Reflection and PHPDoc comments
 - Supports code tags and MarkDown syntax


![Bancha Developer Remote API Screenshot](http://docs.banchaproject.com/wiki/images/BanchaDeveloperRemoteApi-screenshot.jpg)

How to setup the project
------------------------
Asuming you already use Bancha (1.0 Release Candidate or later) on the site, just copy this plugin into _Plugin/_ or _app/Plugin/_ and add following line to your _app/Config/bootstrap.php_:

    CakePlugin::load(array('BanchaDeveloperRemoteApi' => array('routes' => true))); 



More information about Bancha
-----------------------------

*   [Bancha Overview](http://banchaproject.org/)
*   [Updates on Twitter](http://twitter.com/#!/banchaproject)

-------------------------

This is a bancha-flavored light-weight build of [Sencha JSDuck ](https://github.com/senchalabs/jsduck).

This project is distributed under the terms of the GNU General Public License version 3.

THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.