import React, { useEffect, useState, ReactNode } from 'react';
import { PositionType } from '@admin/common/enums/positionType';

interface ModalBackgroundProps {
    position: PositionType;
    children: ReactNode;
}

const ModalBackground: React.FC<ModalBackgroundProps> = ({ position, children }) => {
    const [animateIn, setAnimateIn] = useState(false);

    useEffect(() => {
        const raf = requestAnimationFrame(() => setAnimateIn(true));
        return () => cancelAnimationFrame(raf);
    }, []);

    const baseModalClass = `
    relative bg-white shadow-2xl min-w-[250px] max-h-3/4 transition-all duration-300 ease-in-out transform
  `;

    const wrapperClasses: Record<PositionType, string> = {
        [PositionType.CENTER]: 'mx-auto justify-center max-w-5xl items-center',
        [PositionType.LEFT]: 'justify-start',
        [PositionType.RIGHT]: 'justify-end h-full',
    };

    const modalClassesByPosition: Record<PositionType, string> = {
        [PositionType.CENTER]: 'my-2',
        [PositionType.LEFT]: 'max-h-full',
        [PositionType.RIGHT]: 'max-h-full',
    };

    const positionTransitionClasses: Record<PositionType, string> = {
        [PositionType.LEFT]: animateIn ? 'translate-x-0 opacity-100' : '-translate-x-full opacity-0',
        [PositionType.CENTER]: animateIn
            ? 'translate-y-0 scale-100 opacity-100'
            : '-translate-y-6 scale-95 opacity-0',
        [PositionType.RIGHT]: animateIn ? 'translate-x-0 opacity-100' : 'translate-x-full opacity-0 right-0',
    };

    const borderRadiusClass = position === PositionType.CENTER ? 'rounded-lg' : '';

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
