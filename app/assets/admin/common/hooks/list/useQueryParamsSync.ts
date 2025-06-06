import { useLocation, useNavigate } from 'react-router-dom';
import { useEffect } from 'react';
import { constructUrl } from '@admin/common/utils/helper';

export const useQueryParamsSync = (queryParams: Record<string, any>) => {
  const navigate = useNavigate();
  const location = useLocation();

  useEffect(() => {
    const newUrl = constructUrl('', location.pathname, queryParams);
    navigate(newUrl, { replace: true });
  }, [queryParams]);
}
