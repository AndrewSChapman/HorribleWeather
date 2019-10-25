import ApiClient from '@/ts/core/apiClient';
import {WeatherRequestFactory} from '@/ts/domains/weather/requests/weatherRequestFactory';

export class RequestFactory {
    private apiClient: ApiClient;
    private weatherRequestFactory: WeatherRequestFactory|null = null;

    constructor(apiClient: ApiClient) {
        this.apiClient = apiClient;
    }

    public install(vue: any) {
        Object.defineProperty(vue.prototype, '$requestFactory', { value: this });
    }

    public weather(): WeatherRequestFactory {
        if (!this.weatherRequestFactory) {
            this.weatherRequestFactory = new WeatherRequestFactory(this.apiClient);
        }

        return this.weatherRequestFactory;
    }
}
