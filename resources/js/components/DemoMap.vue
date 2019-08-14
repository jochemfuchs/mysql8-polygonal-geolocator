<template>
    <div>
        <div class="google-map" id="map"></div>
        <div class="form-group">
            <small class="form-text text-muted">Enter a location and the map will try to find it.</small>
            <input type="text" v-model="search" class="form-control" id="locationSearch" placeholder="Enter location">
        </div>
    </div>
</template>
<script>
    import GoogleMaps from "../GoogleMaps";
    import debounce from "tiny-debounce";
    import axios from "axios";

    export default {
        props: {
            zoom: {
                type: Number,
                default: 16
            },
            lat: {
                type: Number
            },
            lon: {
                type: Number
            }
        },
        data() {
            return {
                googleMapsKey: process.env.MIX_GOOGLE_MAPS_KEY,
                loaded: false,
                map: null,
                markers: {},
                markerIds: {},
                page: 1,
                search: null
            }
        },
        watch: {
            search: debounce(function(value) {
                if(value) {
                    this.centerMapOnSearch(value);
                }
            }, 500),
        },
        mounted() {
            this.load();
        },
        methods: {
            fetchMarkers(postData) {
                if(this.markerIds) {
                    postData.markerIds = Object.keys(this.markerIds);
                }

                return axios.post('find-markers', postData);
            },
            fetchMarkersInBounds(mapBounds) {
                let that        = this;
                this.page       = 1;
                this.properties = [];

                this.fetchMarkers({
                    'north' : mapBounds.north,
                    'south' : mapBounds.south,
                    'east'  : mapBounds.east,
                    'west'  : mapBounds.west,
                })
                .then(response => {
                    let {data: {data: markers, links}} = response;

                    if (links.prev === null) {
                        that.page = 1;
                    }

                    if (markers.length > 0) {
                        that.page += 1;
                        that.loadMarkers(markers);
                    }

                    that.links = links;

                    if (typeof that.links.next !== 'undefined' && that.links.next !== null) {
                        that.fetchMarkersInBounds(mapBounds);
                    }
                });
            },
            async load() {
                await GoogleMaps.load(this.googleMapsKey, "EN", 'en');

                this.loaded = true;
                this.initMap();
            },
            loadMarkers(markers) {
                for (let i = 0; i < markers.length; i++) {
                    let marker = markers[i];

                    this.markerIds[marker.id] = true;

                    if(marker.hasOwnProperty('coordinates') && !this.markers.hasOwnProperty(marker.id)) {
                        this.createMarker(marker);
                    }
                }
            },
            createMarker(item) {
                let position = new google.maps.LatLng(item.coordinates.lat, item.coordinates.lon);

                this.markers[item.id] = new google.maps.Marker({
                    position: position,
                    map: this.map
                });
            },
            centerMapOnSearch(search) {
                let geocoder = new google.maps.Geocoder();
                let that     = this;

                geocoder.geocode({
                    'address': search
                }, (results, status) => {
                    if (status === google.maps.GeocoderStatus.OK) {

                        // Center map on location
                        that.map.setCenter(results[0].geometry.location);
                        that.map.fitBounds(results[0].geometry.bounds);
                    } else {
                        alert('Cannot find: ' + search)
                    }
                });
            },
            initMap() {
                this.map = new google.maps.Map(document.getElementById('map'), {
                    zoom  : this.zoom,
                    center: new google.maps.LatLng(this.lat, this.lon),
                    streetViewControl: false,
                    mapTypeControl: false,
                    fullscreenControl: false
                });

                this.map.addListener('bounds_changed', () => {
                    this.boundsChanged();
                });
            },
            boundsChanged: debounce(function() {
                this.fetchMarkersInBounds(this.map.getBounds().toJSON());
            }, 500),
        }
    };
</script>
<style>
    #map {
        margin: 0 auto;
        height: 600px;
        width: 800px;
    }
</style>
