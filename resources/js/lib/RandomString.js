const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

const randomString = (len) => {
    let str = [];
    for (let x = 0; x < len; x++) {
        str.push(chars[Math.floor(Math.random() * chars.length)]);
    }

    return str.join("");
};

export {randomString};