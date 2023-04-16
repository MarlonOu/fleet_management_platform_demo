<template>
    <div>
        <GMap ref="gMap" language="cn" :cluster="{ options: { styles: clusterStyle } }"
            :center="{ lat: 23.0255745527596, lng: 120.22629531746722 }" :options="{ fullscreenControl: false }" :zoom="6">
            <GMapMarker v-for="(location, index) in locations" :key="location.id" style="width: 100px; height: 100px;"
                :position="{ lat: location.lat, lng: location.lng }"
                :options="{ icon: location === locations[index] ? pins.selected : pins.notSelected }"
                @click="currentLocation = location">
                <GMapInfoWindow :options="{ maxWidth: 200 }">
                    <code>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                lat: {{ location.lat }},
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                lng: {{ location.lng }}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                              </code>
                </GMapInfoWindow>
            </GMapMarker>
            <GMapCircle />
        </GMap>
    </div>
</template>
  
<script>


export default {
    props: {
        setLocation: {
            default: [],
            type: Array
        }
    },
    data() {
        return {
            currentLocation: {
                lat: 4411.933076,
                lng: 1225.629058
            },

            locations: [
                {
                    lat: 23.0255745527596,
                    lng: 120.22629531746722
                },
                {
                    lat: 45.815,
                    lng: 1115.9819
                },
                {
                    lat: 452.12,
                    lng: 316.21
                }
            ],
            allLocation: [
                {
                    lat: 23.0255745527596,
                    lng: 120.22629531746722
                },
                {
                    lat: 45.815,
                    lng: 1115.9819
                },
                {
                    lat: 452.12,
                    lng: 316.21
                }
            ],
            pins: {
                selected: "/pins.svg",
                notSelected: "/pins.svg"
            },
            clusterStyle: [
                {
                    url: "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m1.png",
                    width: 56,
                    height: 56,
                    textColor: "#fff"
                }
            ]
        }
    },
    watch: {
        setLocation(val) {
            this.locations = val
            this.$nextTick(() => {
                this.$refs.gMap.initChildren()
            })


        }
    }
}
</script>

