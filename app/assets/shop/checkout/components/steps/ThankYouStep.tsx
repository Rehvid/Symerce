import { createApiConfig } from '../../../../shared/api/ApiConfig';
import { HTTP_METHODS } from '../../../../admin/constants/httpConstants';
import RestApiClient from '../../../../shared/api/RestApiClient';
import { CheckoutStep } from '../../../enums/CheckoutStep';

const ThankYouStep = () => {

  const onSubmit = (values: any) => {
    const apiConfig = createApiConfig(`shop/checkout/save-payment/${values.carrierId}`, HTTP_METHODS.POST);
    apiConfig.setBody(values);

    RestApiClient().sendApiRequest(apiConfig, { onUnauthorized: null }).then(response => {
      const { errors } = response;
      if (errors.length <= 0) {
        //
      }
    });
  }

  return null;
}

export default ThankYouStep;
