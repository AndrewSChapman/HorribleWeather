import { AbstractRequest } from '@/ts/core/abstractRequest';
import { WeatherItem } from '@/ts/domains/weather/interfaces/WeatherItem';

export class SaveLocationRequest extends AbstractRequest {
    public async execute(locationName: string): Promise<WeatherItem> {
        return new Promise<WeatherItem>(async (resolve, reject) => {
            try {
                const response = await this.apiClient.post(`/location`, {
                    name: locationName,
                });

                if (!response.hasOwnProperty('data'))  {
                    reject(Error('SaveLocationRequest - Invalid response from API'));
                    return;
                }

                resolve(response.data);
            } catch (error) {
                reject(this.convertResponseError(error,
                    'Cannot save new location'));
            }
        });
    }
}
