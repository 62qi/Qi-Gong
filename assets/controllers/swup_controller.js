import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect()
    {
        this._onConnect()
        document.addEventListener('swup:contentReplaced', this._onConnect);
    }

    disconnect()
    {
        // You should always remove listeners when the controller is disconnected to avoid side-effects
        this.element.removeEventListener('swup:connect', this._onConnect);
    }

    _onConnect()
    {
        // Swup has just been intialized and you can access details from the event
        const hash = window.location.hash;
        const offset = hash ? document.querySelector(hash).offsetTop : 0;
        window.scrollTo(0, offset);
    }
}
