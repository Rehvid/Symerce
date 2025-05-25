import { useLocation, useNavigate } from 'react-router-dom';
import restApiClient from '@shared/api/RestApiClient';
import { useEffect } from 'react';

export const useQueryParamsSync = (queryParams: Record<string, any>) => {
  const navigate = useNavigate();
  const location = useLocation();

  useEffect(() => {
    const newUrl = restApiClient().constructUrl(queryParams, location.pathname);
    navigate(newUrl, { replace: true });
  }, [queryParams]);
}
