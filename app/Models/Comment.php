<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory , SoftDeletes;
    const Status = ['approved','pending','rejected'];
    protected $fillable = [
        'article_id',
        'user_id',
        'content',
        'parent_id',
        'status',
        'delete_reason'
    ];

    private static $bannedKeywords = [
        // Bạo lực và Tội phạm
        'bạo lực',
        'đánh đập',
        'đâm chém',
        'giết người',
        'mạng sống',
        'tội phạm',
        'cướp bóc',
        'khủng bố',
        'hành hung',
        'phá hoại',
        'đánh nhau',
        'tranh cãi',
        'đối đầu',
        'giết người hàng loạt',
        'đánh nhau đẫm máu',
        'bạo loạn',
        'thảm sát',
        'buôn bán ma túy',
        'tổ chức tội phạm',
        'phá hoại tài sản',

        // Chính trị và Xã hội
        'phản động',
        'chống phá',
        'phản quốc',
        'độc tài',
        'thủ đoạn chính trị',
        'cuộc cách mạng',
        'bạo loạn',
        'nổi loạn',
        'phản bội',
        'kỳ thị chính trị',
        'phân biệt chủng tộc',
        'chiến tranh lạnh',
        'biểu tình',
        'cuộc chiến chính trị',
        'đảng phái',
        'thể chế độc tài',
        'đấu tranh chính trị',
        'tổ chức phi chính phủ',
        'cuộc cách mạng dân chủ',
        'phá hoại chính quyền',

        // Ma túy và Hành vi phi pháp
        'ma túy',
        'buôn bán ma túy',
        'lừa đảo',
        'gian lận',
        'tham nhũng',
        'hối lộ',
        'bảo kê',
        'ma túy đá',
        'cờ bạc',
        'tổ chức tội phạm',
        'cấm thuốc lá',
        'cấm rượu',
        'lạm dụng',
        'bị giam giữ',
        'hành vi phi pháp',
        'giả mạo giấy tờ',
        'buôn lậu',
        'buôn bán người',
        'lạm dụng quyền lực',
        'tội ác nghiêm trọng',

        // Bạo lực gia đình và Xâm hại
        'xâm hại tình dục',
        'lạm dụng trẻ em',
        'bạo lực gia đình',
        'đánh đập vợ',
        'đánh đập trẻ em',
        'hiếp dâm',
        'quấy rối tình dục',
        'xâm phạm thân thể',
        'đánh đập vợ chồng',
        'lạm dụng thể xác',
        'tình dục cưỡng ép',
        'bạo hành',
        'tổn thương tinh thần',
        'hành vi bạo lực',
        'hiếp dâm tập thể',
        'nô lệ tình dục',
        'phá thai',
        'tra tấn',
        'cưỡng ép',
        'cướp giật',

        // Đời sống và Các hành vi xã hội
        'chán nản',
        'tự tử',
        'trầm cảm',
        'stress',
        'tuổi trẻ nổi loạn',
        'vô gia cư',
        'người ăn xin',
        'nạn đói',
        'nạn nghèo',
        'thất nghiệp',
        'nợ nần',
        'đau khổ',
        'tầm nhìn hạn hẹp',
        'không có hy vọng',
        'quá khích',
        'đơn độc',
        'vô vọng',
        'kỳ thị xã hội',
        'thất bại',
        'khó khăn',

        // Xâm phạm quyền riêng tư
        'vi phạm quyền riêng tư',
        'gián điệp',
        'do thám',
        'phá mật khẩu',
        'thăm dò thông tin',
        'hack tài khoản',
        'đánh cắp dữ liệu',
        'quấy rối trực tuyến',
        'lộ thông tin cá nhân',
        'lừa đảo trực tuyến',
        'tấn công mạng',
        'giả danh',
        'sao chép trái phép',
        'phát tán thông tin sai lệch',
        'phá hoại dữ liệu',
        'làm giả tài liệu',
        'vi phạm bản quyền',
        'sử dụng thông tin trái phép',
        'giải mã dữ liệu',
        'điều tra trái phép',

        // Các vấn đề về sức khỏe
        'ung thư',
        'bệnh tật',
        'đau đớn',
        'mắc bệnh truyền nhiễm',
        'phẫu thuật',
        'khám bệnh',
        'thuốc cấm',
        'lạm dụng thuốc',
        'điều trị sai cách',
        'trái phép',
        'cấp cứu',
        'cắt cụt',
        'phẫu thuật thẩm mỹ',
        'tiêm chủng',
        'viêm gan',
        'tiểu đường',
        'lo âu',
        'khó thở',
        'không thể hồi phục',
        'không chữa trị',

        // Vấn đề học vấn và giáo dục
        'thi trượt',
        'lười học',
        'đi học muộn',
        'đi học bỏ',
        'thiếu giáo dục',
        'không có kiến thức',
        'không học hành',
        'trốn học',
        'điểm kém',
        'không qua môn',
        'thiếu giáo viên',
        'thiếu tài liệu',
        'phương pháp học sai',
        'trì hoãn',
        'tự học kém',
        'không đạt yêu cầu',
        'đi học lại',
        'đi học thiếu tập trung',
        'học tủ',
        'không đủ bài',

        // Bệnh tâm lý và Các vấn đề tinh thần
        'trầm cảm',
        'nỗi sợ',
        'lo âu',
        'cảm giác tội lỗi',
        'chán nản',
        'cảm giác vô dụng',
        'đau buồn',
        'stress',
        'khủng hoảng tinh thần',
        'rối loạn ăn uống',
        'rối loạn tâm lý',
        'trầm cảm hậu sản',
        'lo âu xã hội',
        'khủng hoảng cá nhân',
        'khủng hoảng sức khỏe',
        'hành vi bạo lực',
        'mất trí nhớ',
        'mất phương hướng',
        'cảm giác tự ti',
        'mất kiểm soát',

        // Kỳ thị và Phân biệt đối xử
        'phân biệt chủng tộc',
        'kỳ thị giới tính',
        'kỳ thị xã hội',
        'phân biệt giai cấp',
        'kỳ thị tôn giáo',
        'kỳ thị sắc tộc',
        'kỳ thị đối với người khuyết tật',
        'phân biệt đối xử',
        'phân biệt giàu nghèo',
        'kỳ thị sắc đẹp',
        'phân biệt tuổi tác',
        'kỳ thị về ngôn ngữ',
        'kỳ thị về ngoại hình',
        'kỳ thị với người ngoại quốc',
        'phân biệt trong công việc',
        'phân biệt học vấn',
        'kỳ thị đối với người đồng tính',
        'phân biệt trong tuyển dụng',
        'phân biệt trong giáo dục',

        // Nội dung khiêu dâm
        'khiêu dâm',
        'hình ảnh khiêu dâm',
        'video khiêu dâm',
        'giới tính phóng túng',
        'sex trực tuyến',
        'ảnh nóng',
        'nội dung phản cảm',
        'liên kết khiêu dâm',
        'đồi trụy',
        'mô phỏng khiêu dâm',
        'video đồi trụy',
        'quấy rối tình dục',
        'khiêu dâm trẻ em',
        'khiêu dâm người lớn',
        'khuyến khích hành vi tình dục',
        'tình dục không an toàn',
        'hành động đồi trụy',
        'mạng khiêu dâm',
        'khiêu dâm bạo lực',
        'phim đen',

        // Các hành vi bạo lực và chiến tranh
        'chiến tranh',
        'quân đội xâm lược',
        'phá hủy',
        'đánh bom',
        'thảm sát',
        'kỹ thuật chiến tranh',
        'cuộc chiến đẫm máu',
        'quân sự hóa',
        'nội chiến',
        'đánh nhau giữa các quốc gia',
        'khu vực chiến sự',
        'nạn chiến tranh',
        'vụ tấn công',
        'quân lính',
        'vũ khí chiến tranh',
        'đặc công',
        'khủng bố',
        'kháng chiến',
        'kế hoạch quân sự',

        // Tội phạm mạng và bảo mật
        'hack',
        'virus máy tính',
        'phần mềm độc hại',
        'virus',
        'phá mã',
        'tấn công mạng',
        'phát tán phần mềm độc hại',
        'đánh cắp dữ liệu',
        'quét thẻ tín dụng',
        'phishing',
        'giả mạo website',
        'lừa đảo trực tuyến',
        'tấn công DDos',
        'vi phạm bảo mật',
        'đánh cắp tài khoản',
        'phá hoại hệ thống',
        'trộm cắp điện tử',
        'phát tán mã độc',
        'virus máy tính'
    ];

    public static function getBannerKeywords()
    {
        return self::$bannedKeywords;
    }

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ một bình luận cha có thể có nhiều bình luận con
    public function parentComment()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Quan hệ một bình luận có thể có nhiều bình luận con (trả lời)
    public function childComments()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('childComments');
    }
}
