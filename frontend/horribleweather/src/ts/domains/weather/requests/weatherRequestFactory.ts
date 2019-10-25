import ApiClient from '@/ts/core/apiClient';
import { CheckLocationRequest } from '@/ts/domains/weather/requests/CheckLocationRequest';
import {SaveLocationRequest} from '@/ts/domains/weather/requests/SaveLocationRequest';

export class WeatherRequestFactory {
    private apiClient: ApiClient;

    constructor(apiClient: ApiClient) {
        this.apiClient = apiClient;
    }

    public get checkLocation(): CheckLocationRequest {
        return new CheckLocationRequest(this.apiClient);
    }

    public get saveLocation(): SaveLocationRequest {
        return new SaveLocationRequest(this.apiClient);
    }
}
