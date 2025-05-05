import { POSITION_TYPES } from '@/admin/constants/positionConstants';
import { useEffect, useState } from 'react';

const ModalBackground = ({ position, children }) => {
    const [animateIn, setAnimateIn] = useState(false);

    useEffect(() => {
        const raf = requestAnimationFrame(() => setAnimateIn(true));
        return () => cancelAnimationFrame(raf);
    }, []);

    const baseModalClass = `
    relative bg-white shadow-2xl min-w-[250px] max-h-3/4 transition-all duration-300 ease-in-out transform
  `;

    const wrapperClasses = {
        [POSITION_TYPES.CENTER]: 'mx-auto justify-center max-w-5xl items-center',
        [POSITION_TYPES.LEFT]: 'justify-start ',
        [POSITION_TYPES.RIGHT]: 'justify-end h-full',
    };

    const modalClassesByPosition = {
        [POSITION_TYPES.CENTER]: 'my-2',
        [POSITION_TYPES.LEFT]: 'max-h-full',
        [POSITION_TYPES.RIGHT]: 'max-h-full',
    };

    const positionTransitionClasses = {
        [POSITION_TYPES.LEFT]: animateIn ? 'translate-x-0 opacity-100' : '-translate-x-full opacity-0',
        [POSITION_TYPES.CENTER]: animateIn
            ? 'translate-y-0 scale-100 opacity-100'
            : '-translate-y-6 scale-95 opacity-0',
        [POSITION_TYPES.RIGHT]: animateIn ? 'translate-x-0 opacity-100' : 'translate-x-full opacity-0 right-0',
    };

    const borderRadiusClass = position === POSITION_TYPES.CENTER ? 'rounded-lg' : '';

    return (
        <div className="h-full overflow-auto">
            <div className={`relative w-full flex ${wrapperClasses[position]}`}>
                <div
                    className={`${baseModalClass} ${modalClassesByPosition[position]} ${positionTransitionClasses[position]} ${borderRadiusClass}`}
                >
                    {children}
                </div>
            </div>
        </div>
    );
};

export default ModalBackground;
