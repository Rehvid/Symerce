import React, { useEffect, useState, ReactNode } from 'react';
import { ModalPositionType } from '@admin/common/enums/modalPositionType';

interface ModalBackgroundProps {
    position: ModalPositionType;
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

    const wrapperClasses: Record<ModalPositionType, string> = {
        [ModalPositionType.CENTER]: 'mx-auto justify-center max-w-5xl items-center',
        [ModalPositionType.LEFT]: 'justify-start',
        [ModalPositionType.RIGHT]: 'justify-end h-full',
    };

    const modalClassesByPosition: Record<ModalPositionType, string> = {
        [ModalPositionType.CENTER]: 'my-2',
        [ModalPositionType.LEFT]: 'max-h-full',
        [ModalPositionType.RIGHT]: 'max-h-full',
    };

    const positionTransitionClasses: Record<ModalPositionType, string> = {
        [ModalPositionType.LEFT]: animateIn ? 'translate-x-0 opacity-100' : '-translate-x-full opacity-0',
        [ModalPositionType.CENTER]: animateIn
            ? 'translate-y-0 scale-100 opacity-100'
            : '-translate-y-6 scale-95 opacity-0',
        [ModalPositionType.RIGHT]: animateIn ? 'translate-x-0 opacity-100' : 'translate-x-full opacity-0 right-0',
    };

    const borderRadiusClass = position === ModalPositionType.CENTER ? 'rounded-lg' : '';

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
