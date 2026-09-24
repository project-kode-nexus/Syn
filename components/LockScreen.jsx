import React, { useEffect } from 'react'
import usePhoneStore from '@/store/usePhone';
import { useSwipeable } from 'react-swipeable';
import Image from 'next/image';

const LockScreen = ({ unlock }) => {
    const { currentTime, setCurrentTime } = usePhoneStore();

    useEffect(() => {
        const interval = setInterval(setCurrentTime(), 60000); // Update every minute
        return () => clearInterval(interval);
    }, [setCurrentTime]);

    const handlers = useSwipeable({
        onSwipedUp: () => unlock(),
        swipeDuration: 5000,
        preventScrollOnSwipe: true,
        trackMouse: true
    });

    return (
        <div className="h-full w-full flex flex-col justify-center gap-40" style={{ backgroundImage: "url('/wall.webp')", backgroundSize: 'cover', backgroundPosition: 'center' }} {...handlers}>
            <Image src="/wall.webp" alt="Background" layout="fill" className="absolute -z-10 object-cover" draggable={false} onContextMenu={(e) => e.preventDefault()} />
            
            <div className="text-6xl text-center text-white" suppressHydrationWarning>
                {currentTime.getHours().toString().padStart(2, '0')}:{currentTime.getMinutes().toString().padStart(2, '0')}
            </div>

            <div className="text-center w-full block">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-26 mx-auto">
                    <path strokeLinecap="round" strokeLinejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                </svg>

                <span className='text-white' style={{
                    fontSize: '3.6vh',
                }}>Swipe To Unlock</span>
            </div>
        </div>
    )
}

export default LockScreen;
