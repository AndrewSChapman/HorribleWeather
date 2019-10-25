<template>
    <div class="weather-location" :class="{'most-deplorable': mostDeplorable}">
        <div class="location-icon">
            <img :src="'https://openweathermap.org/img/wn/' + weatherItem.icon + '@2x.png'" />
        </div>
        <div class="location-info">
            <h3>{{ weatherItem.locationName }} {{ weatherItem.temperature }} &deg;C</h3>
            <p>{{ weatherItem.type }}: {{ weatherItem.description }}</p>
            <p>Wind gusts at {{ weatherItem.windSpeed }} km/hour</p>
        </div>
        <div class="score">
            <h3>Deporability Score: {{ weatherItem.score }}</h3>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Prop, Vue } from 'vue-property-decorator';
    import { WeatherItem } from '@/ts/domains/weather/interfaces/WeatherItem';

    @Component
    export default class WeatherLocation extends Vue {
        @Prop({ required: true })
        public weatherItem!: WeatherItem;

        @Prop({ required: true })
        public mostDeplorable!: boolean;
    }
</script>

<style scoped lang="scss">
    .weather-location {
        background-color:#0093D1;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 6px;
        display: flex;
    }

    h3 {
        font-size: 18pt;
    }

    p {
        font-size: 14pt;
    }

    .location-icon {
        width: 20%;
        min-width: 80px;
    }


    .location-info {
        width: 50%;
    }

    .most-deplorable {
        background-color: #F2635F;
    }

    .score {
        width: 30%;
    }



    h3 {
        margin: 0;
        padding: 0;
    }

    p {
        margin: 0;
        padding: 0;
    }
</style>
