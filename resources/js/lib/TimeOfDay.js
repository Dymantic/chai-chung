class TimeOfDay {



    constructor(time) {
        this.hours = parseInt(time.slice(0,2));
        this.mins = parseInt(time.slice(3,5));

        this.accepts = {
            0: [0, 1, 2],
            1: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            2: [0, 3],
            3: [0]
        };
    }

    setPoint(value, position) {
        if ((!this.accepts[position]) || !this.accepts[position].includes(value)) {
            return false;
        }
        switch (position) {
            case 0:
                this.hours = (value * 10) + (this.hours % 10);
                break;
            case 1:
                if((Math.floor(this.hours/10) === 2) && value > 3) {
                    return false;
                }
                this.hours = (Math.floor(this.hours / 10) * 10) + value;
                break;
            case 2:
                this.mins = (value * 10) + (this.mins % 10);
                break;
            case 3:
                this.mins = (Math.floor(this.mins / 10) * 10) + value;
                break;
            default:
                break;
        }

        return true;
    }

    getPoint(position) {
        switch (position) {
            case 0:
                return Math.floor(this.hours / 10);
            case 1:
                return this.hours % 10;
            case 2:
                return Math.floor(this.mins / 10);
            case 3:
                return this.mins % 10;
            default:
                return null;
        }
    }

    addMinutes(minutes) {
        const time_in_mins = (this.hours * 60) + this.mins + minutes;
        if((time_in_mins >= (60 * 24)) || (time_in_mins) < 0) {
            return;
        }

        this.hours = Math.floor(time_in_mins/60);
        this.mins = time_in_mins % 60;
    }

    asString() {
        function pad(val) {
                return val < 10 ? `0${val}` : `${val}`;
        }

        return `${pad(this.hours)}:${pad(this.mins)}`;
    }

}

export {TimeOfDay};