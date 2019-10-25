import ApiClient from '@/ts/core/apiClient';
import { ErrorObject } from '@/ts/core/interfaces/errorObject';

export abstract class AbstractRequest {
    protected apiClient: ApiClient;

    constructor(apiClient: ApiClient) {
        this.apiClient = apiClient;
    }

    protected convertResponseError(error: any, defaultMessage: string): ErrorObject {
        if ((error.hasOwnProperty('response')) && (error.response) && (error.response.hasOwnProperty('data')) &&
            (error.response.data.hasOwnProperty('error'))) {
            const dataObject = error.response.data;
            const errorMessage = dataObject.error;
            const errorCode = dataObject.hasOwnProperty('code') ? dataObject.code : '';

            return this.createErrorObject(errorMessage, errorCode);
        } else {
            return this.createErrorObject(defaultMessage, '');
        }
    }

    private createErrorObject(message: string, code: string): ErrorObject {
        return {
            message,
            code,
            toString: () => {
                return message;
            },
        };
    }
}
