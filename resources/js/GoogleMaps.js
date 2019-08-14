export default class GoogleMaps {

    static async load(key, region, locale) {
        this.key = key;
        this.region = region;
        this.locale = locale;

        await this.loadMapsApi();
    }

    static async loadMapsApi() {
        return new Promise(next => {
            if (!window.google) {
                window['onMapsInit'] = next;

                let script = document.createElement('script');

                script.setAttribute(
                    'src',
                    `https://maps.googleapis.com/maps/api/js?key=${this.key}&callback=onMapsInit&language=${this.locale}&region=${this.region}`
                );

                document.body.appendChild(script);
            } else {
                next();
            }
        });
    }
}
