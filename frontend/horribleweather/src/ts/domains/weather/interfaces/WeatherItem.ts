export interface WeatherItem {
    id: string;
    createdAt: number;
    updatedAt: number;
    type: string;
    locationId: string;
    locationName: string;
    description: string;
    temperature: number;
    windSpeed: number;
    icon: string;
    score: number;
}
