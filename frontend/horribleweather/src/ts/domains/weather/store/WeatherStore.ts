import { Module, VuexModule, Mutation, Action } from 'vuex-module-decorators';
import { WeatherItem } from '@/ts/domains/weather/interfaces/WeatherItem';
import ApiClient from '@/ts/core/apiClient';
import { GetCurrentWeatherRequest } from '@/ts/domains/weather/requests/getCurrentWeatherRequest';

@Module
export class WeatherStore extends VuexModule {
    public weatherItems: WeatherItem[] = [];

    public errorMessage = {
        loadLatestWeather: '',
    };

    @Mutation
    public setWeatherItems(weatherItems: WeatherItem[]) {
        this.weatherItems = weatherItems;
    }

    @Action
    public async loadLatestWeather(state: any): Promise<void> {
        const myWindow: any = window;
        const apiClient: ApiClient = myWindow.apiClient;
        const request = new GetCurrentWeatherRequest(apiClient);

        try {
            const weatherItems = await request.execute();
            this.context.commit('setWeatherItems', weatherItems);
        } catch (error) {
            this.errorMessage.loadLatestWeather = error.toString();
        }
    }
}
