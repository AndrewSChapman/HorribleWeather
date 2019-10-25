import { AbstractRequest } from '@/ts/core/abstractRequest';
import { WeatherItem } from '@/ts/domains/weather/interfaces/WeatherItem';

export class CheckLocationRequest extends AbstractRequest {
    public async execute(locationName: string): Promise<WeatherItem> {
        return new Promise<WeatherItem>(async (resolve, reject) => {
            try {
                const response = await this.apiClient.get(`/location-check?name=${locationName}`);

                if (!response.hasOwnProperty('data'))  {
                    reject(Error('CheckLocationRequest - Invalid response from API'));
                    return;
                }

                resolve(response.data);
            } catch (error) {
                reject(this.convertResponseError(error,
                    'Invalid location name'));
            }
        });
    }
}
