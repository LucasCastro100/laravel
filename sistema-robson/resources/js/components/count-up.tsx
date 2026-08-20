import { useEffect, useRef, useState } from 'react';

type Props = {
    target: number;
    duration?: number;
    suffix?: string;
    decimals?: number;
};

export function CountUp({ target, duration = 2000, suffix = '', decimals = 0 }: Props) {
    const [count, setCount] = useState(0);
    const ref = useRef<HTMLSpanElement>(null);
    const hasAnimated = useRef(false);

    useEffect(() => {
        const element = ref.current;
        if (!element) return;

        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting && !hasAnimated.current) {
                    hasAnimated.current = true;

                    const startTime = performance.now();

                    const animate = (currentTime: number) => {
                        const elapsed = currentTime - startTime;
                        const progress = Math.min(elapsed / duration, 1);

                        const eased = 1 - Math.pow(1 - progress, 3);

                        setCount(Math.floor(eased * target));

                        if (progress < 1) {
                            requestAnimationFrame(animate);
                        } else {
                            setCount(target);
                        }
                    };

                    requestAnimationFrame(animate);
                }
            },
            { threshold: 0.3 },
        );

        observer.observe(element);

        return () => observer.disconnect();
    }, [target, duration]);

    const formatted = decimals > 0 ? count.toFixed(decimals) : count.toLocaleString('pt-BR');

    return (
        <span ref={ref}>
            {formatted}{suffix}
        </span>
    );
}
