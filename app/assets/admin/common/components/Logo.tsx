import React from 'react';
// @ts-ignore
import LogoImage from '@/images/logo.png';

interface LogoProps {
    classesName?: string;
}

const Logo: React.FC<LogoProps> = ({ classesName }) => <img src={LogoImage} alt="Logo" className={classesName} />;

export default Logo;
