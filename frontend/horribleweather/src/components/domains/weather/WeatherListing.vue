<template>
    <div class="weather-listing">
        <p v-if="currentWeatherItems.length === 0">Please wait, loading weather...</p>

        <WeatherLocation v-for="weatherItem in currentWeatherItems"
                         v-bind:key="weatherItem.id"
                         :weather-item="weatherItem"
                         :most-deplorable="isMostDeplorable(weatherItem)"
        />

        <p class="new-location-added" v-if="newLocationAdded">
            Your new location will show in a minute or so once the latest weather for
            all locations has been refreshed.  Please have patience.
        </p>

        <AddNewLocation @new-location-added="handleNewLocationAdded" />
    </div>
</template>

<script lang="ts">
    import { Component, Prop, Vue } from 'vue-property-decorator';
    import { WeatherItem } from '@/ts/domains/weather/interfaces/WeatherItem';
    import WeatherLocation from '@/components/domains/weather/WeatherLocation.vue';
    import AddNewLocation from '@/components/domains/weather/AddNewLocation.vue';

    @Component({
        components: {
            AddNewLocation,
            WeatherLocation,
        },
    })
    export default class WeatherListing extends Vue {
        public newLocationAdded = false;

        public mounted(): void {
            this.$store.dispatch('loadLatestWeather');

            setInterval(() => {
                this.$store.dispatch('loadLatestWeather');
                this.newLocationAdded = false;
            }, 60000);
        }

        get currentWeatherItems(): WeatherItem[] {
            return this.$store.state.weather.weatherItems;
        }

        public isMostDeplorable(weatherItem: WeatherItem): boolean {
            return weatherItem.score === this.mostDeplorableScore;
        }

        public handleNewLocationAdded(): void {
            this.newLocationAdded = true;
        }

        private get mostDeplorableScore(): number {
            if (this.currentWeatherItems.length === 0) {
                return -1;
            }

            return this.currentWeatherItems[0].score;
        }
    }
</script>

<style scoped lang="scss">
    .weather-listing {
        margin-bottom: 150px;
    }

    .new-location-added {
        background-color: white;
        color: #004C70;
        font-weight: bold;
        padding: 10px;
    }
</style>
