import { AbstractRequest } from '@/ts/core/abstractRequest';
import { WeatherItem } from '@/ts/domains/weather/interfaces/WeatherItem';

export class GetCurrentWeatherRequest extends AbstractRequest {
    public async execute(): Promise<WeatherItem[]> {
        return new Promise<WeatherItem[]>(async (resolve, reject) => {
            try {
                const response = await this.apiClient.get(`/weather`);

                if (!response.hasOwnProperty('data'))  {
                    reject(Error('GetCurrentWeatherRequest - Invalid response from API'));
                    return;
                }

                resolve(response.data);
            } catch (error) {
                reject(this.convertResponseError(error,
                    'Could not load current weather list from the API'));
            }
        });
    }
}
