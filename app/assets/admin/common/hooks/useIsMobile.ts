import { useEffect, useState } from 'react';

export const useIsMobile = (): boolean => {
    const MOBILE_WIDTH = 1023;
    const [isMobile, setIsMobile] = useState<boolean>(window.innerWidth <= MOBILE_WIDTH);

    useEffect(() => {
        const handleResize = () => {
            setIsMobile(window.innerWidth <= MOBILE_WIDTH);
        };

        window.addEventListener('resize', handleResize);

        return () => window.removeEventListener('resize', handleResize);
    }, []);

    return isMobile;
};
