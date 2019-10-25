<template>
    <div class="add-location">
        <p v-if="!showAddNewLocationForm">
            <a href="javascript:void(0);" @click="showAddNewLocationForm = true">Add a new location to the listing</a>
        </p>

        <form v-if="showAddNewLocationForm" id="frmAddNewLocation">
            <fieldset>
                <div class="input-group">
                    <label for="locationName">Enter the name of a location</label>
                    <input id="locationName"
                           type="search"
                           placeholder="e.g. Bristol,uk"
                           :disabled="loading"
                           v-model="locationName"
                           @keyup="handleKeyPress"
                    />
                    <span class="spinner" v-if="loading">
                        <font-awesome-icon :icon="['fas', 'spinner']" spin />
                    </span>
                </div>
            </fieldset>
        </form>

        <div class="error-message" v-if="errorMessage.length > 0">
            <h3>The following error occurred</h3>
            <p>{{ errorMessage }}</p>
        </div>

        <div v-if="unsupportedLocation" class="unsupported-location">
            <h1>Unsupported Location!</h1>
        </div>

        <div v-if="unverifiedWeatherItem" class="verify-location">
            <h2>We found the following current weather for &lsquo;{{ locationName }}&rsquo;</h2>

            <dl>
                <dt>Temperature:</dt>
                <dd>{{ unverifiedWeatherItem.temperature }} &deg;C</dd>
                <dt>Current Conditions:</dt>
                <dd>{{ unverifiedWeatherItem.type }}</dd>
                <dt>Wind speed:</dt>
                <dd>{{ unverifiedWeatherItem.windSpeed }} km/h</dd>
            </dl>

            <div class="actions" v-if="!saving">
                <button class="positive" @click="saveLocation">Seems legit, add this location</button>
                <button class="neutral" @click="cancelNewLocation">Cancel</button>
            </div>

            <div class="saving-spinner" v-if="saving">
                <font-awesome-icon :icon="['fas', 'spinner']" spin />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import { Component, Prop, Vue } from 'vue-property-decorator';
    import { WeatherItem } from '@/ts/domains/weather/interfaces/WeatherItem';
    import {RequestFactory} from '@/ts/core/requestFactory';

    @Component({
        components: {

        },
    })
    export default class AddNewLocation extends Vue {
        // Variables used in template
        public showAddNewLocationForm = false;
        public unverifiedWeatherItem: WeatherItem|null = null;
        public unsupportedLocation = false;
        public errorMessage = '';

        // Model variables
        public locationName = '';

        // Variables not used in template
        private timeout: any = null;
        private loading = false;
        private saving = false;
        private $requestFactory!: RequestFactory;

        public handleKeyPress(): void {
            this.unsupportedLocation = false;

            if (this.timeout !== null) {
                clearTimeout(this.timeout);
            }

            this.timeout = setTimeout(() => {
                if (this.locationName.length > 0) {
                    this.checkWeatherLocation();
                }
            }, 1000);
        }

        public cancelNewLocation(): void {
            this.unverifiedWeatherItem = null;
            this.locationName = '';
        }

        public async saveLocation(): Promise<void> {
            try {
                this.saving = true;

                const saveLocationRequest = this.$requestFactory.weather().saveLocation;
                await saveLocationRequest.execute(this.locationName);

                this.$emit('new-location-added');
            } catch (error) {
                this.errorMessage = error.toString();
            } finally {
                this.saving = false;
                this.cancelNewLocation();
            }
        }

        private async checkWeatherLocation(): Promise<void> {
            try {
                this.loading = true;
                this.unverifiedWeatherItem = null;

                this.enforceCountryOnLocationName();

                const checkLocationRequest = this.$requestFactory.weather().checkLocation;
                this.unverifiedWeatherItem = await checkLocationRequest.execute(this.locationName);
            } catch (error) {
                this.unsupportedLocation = true;
            } finally {
                this.loading = false;
            }
        }

        private enforceCountryOnLocationName(): void {
            if (this.locationName.length === 0) {
                return;
            }

            const parts = this.locationName.split(',');
            if (parts.length === 1) {
                this.locationName = this.locationName + ',uk';
            }
        }
    }
</script>

<style lang="scss" scoped>
    a {
        color: white;
        font-weight: bold;

        &:hover {
            color: #E0A025;
        }
    }

    form {
        margin: 20px 0;
        padding: 0;
    }

    fieldset {
        border: 0;
        margin: 0;
        padding: 0;
    }

    .input-group {
        position: relative;
        width: 80%;
    }

    label {
        font-weight: bold;
        font-size: 14pt;
    }

    .spinner {
        color: #000000;
        position: absolute;
        right: 20px;
        top: 45px;
    }

    input[type="search"] {
        padding: 10px;
        border-radius: 6px;
        width: 100%;
        font-size: 14pt;
        background-color: #DDDDDD;

        &:focus {
            background-color: #FFFFFF;
        }
    }

    .verify-location {
        background-color: white;
        border-radius: 6px;
        padding: 20px;
        color: black;

        h2 {
            margin-top: 0;
        }

        dl {
            width: 300px;
        }

        dt {
            display: inline-block;
            width: 50%;
            margin: 0;
            padding: 0;
            font-weight: bold;
        }

        dd {
            display: inline-block;
            width: 40%;
            margin: 0;
            padding: 0;
            color: #004C70;
        }
    }

    .actions {
        button {
            background-color: #AAAAAA;
            color: black;
            border-radius: 6px;
            border: none;
            padding: 10px;
            margin: 0;
            font-weight: bold;
            opacity: 0.8;

            &:hover {
                cursor: pointer;
                opacity: 1.0;
            }
        }

        .positive {
            margin-right: 15px;
            background-color: #0093D1;
            color: white;
        }
    }

    .saving-spinner {
        width: 100%;
        margin: 20px 0;
        text-align: center;
        color: #E0A025;
        font-size: 26pt;
    }

    .error-message {
        padding: 20px;
        background-color: white;
        color: #F2635F;
    }
</style>
