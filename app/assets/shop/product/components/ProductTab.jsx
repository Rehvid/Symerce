import { useEffect, useRef, useState } from 'react';
import DescriptionTab from '@/shop/product/components/TabComponents/DescriptionTab';
import ParamTab from '@/shop/product/components/TabComponents/ParamTab';


const ProductTab = ({types, activeTab, activeTabTarget, defaultActiveTabType}) => {
    const [tabs, setTabs] = useState([activeTab]);
    const [active, setActive] = useState(activeTab.type);
    const [activeElement, setActiveElement] = useState(activeTabTarget);

    const prevActiveElementRef = useRef(null);
    const isFirstRender = useRef(true);

    useEffect(() => {
        const previousElement = document.querySelector(`[data-type="${defaultActiveTabType}"]`);
        handleTargetClasses(activeElement,  previousElement);
        prevActiveElementRef.current = activeElement;
    }, []);

    useEffect(() => {
        if (isFirstRender.current) {
            isFirstRender.current = false;
            return;
        }

        if (activeElement) {
            handleTargetClasses(activeElement, prevActiveElementRef.current);
        }
    }, [active]);


    useEffect(() => {
        const handleClick = (e) => {
            const target = e.target;
            if (target.classList.contains('react-product-tab-element')) {
                handleTab(target);
            }
        };

        document.addEventListener('click', handleClick);
        // eslint-disable-next-line consistent-return
        return () => document.removeEventListener('click', handleClick);
    }, [types]);

    const handleTab = (target) => {
        const type = target.getAttribute('data-type');
        const content = target.getAttribute('data-content');

        console.log(types);
        if ((!type || !types.includes(type)) || !content) {
            return;
        }

        setActiveElement(target);
        setTabs(prevTabs => {
            const exists = prevTabs.find(tab => tab.type === type);
            if (exists) {
                return prevTabs;
            }
            return [...prevTabs, { type, content }];
        });

        handleTargetClasses(target, prevActiveElementRef.current);
        prevActiveElementRef.current = target;
        setActiveElement(target);
        setActive(type);
    }

    const renderContent = () => {
        const content = tabs.find(tab => tab.type === active);
        if (!content) {
            return null;
        }

        switch (active) {
            case 'description':
                return <DescriptionTab content={content.content}/>;
            case 'param':
                return <ParamTab content={content.content}/>;
            default:
                return null;
        }
    };

    const handleTargetClasses = (target, previousElement) => {
        const activeClasses = ['text-primary', 'border-primary'];
        const defaultClasses = ['border-transparent', 'hover:text-primary', 'hover:border-primary'];

        if (previousElement) {
            activeClasses.forEach((className) => previousElement.classList.remove(className));
            defaultClasses.forEach((className) => previousElement.classList.add(className));
        }

        defaultClasses.forEach((className) => target.classList.remove(className));
        activeClasses.forEach((className) => target.classList.add(className));
    };

    return renderContent();
}

export default ProductTab;
